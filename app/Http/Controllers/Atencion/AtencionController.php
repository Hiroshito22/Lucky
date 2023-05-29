<?php

namespace App\Http\Controllers\Atencion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Servicio;
use App\Models\Atencion;
use App\Models\AtencionServicio;
use App\Imports\AtencionImport;
use App\Models\Persona;
use App\Models\Trabajador;
use App\User;
use App\Models\HistoriaClinica;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EmpresaPaquete;
use App\Models\EmpresaPersonal;
use App\Models\HojaRuta;
use App\Models\HojaRutaDetalle;
use App\Models\Paciente;
use App\Models\Rol;
use Exception;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

use function PHPUnit\Framework\returnSelf;

class AtencionController extends Controller
{
    public function admin($tipo_acceso, $url)
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == $tipo_acceso && $accesos['url'] == $url) {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }
    public function createTrabajadores(Request $request)
    {
        if ($this->admin(3, '/atenciones') == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        try {
            $usuario = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
            $empresa = Empresa::where("ruc", $usuario->persona->numero_documento)->first();
            if ($empresa) {
                $empresa = $empresa;
            }
            $trabajadores_enviados = $request->trabajadores;
            //$paquete = Paquete::find($request->paquete_id);
            $servicios = Servicio::select('servicio.id')
                ->join('servicio_hospital', 'servicio.id', 'servicio_hospital.servicio_id')
                ->join('servicio_producto', 'servicio_hospital.id', 'servicio_producto.servicio_hospital_id')
                ->join('producto', 'servicio_producto.producto_id', 'producto.id')
                ->join('producto_paquete', 'producto.id', 'producto_paquete.producto_id')
                ->join('paquete', 'producto_paquete.paquete_id', 'paquete.id')
                ->where('servicio.estado_registro', 'A')
                ->where('paquete.id', $request->paquete_id)
                ->get();
            $empresa_paquete = EmpresaPaquete::where('paquete_id', $request->paquete_id)->first();
            //return response()->json($servicios,201);
            foreach ($trabajadores_enviados as $trabs) {

                $atencion = Atencion::create([
                    "trabajador_id" => $trabs["id"],
                    "empresa_id" => $empresa->id,
                    "fecha_emision" => date("Y-m-d"),
                    "fecha_atencion" => $request->fecha_atencion,
                    "estado_atencion" => 0,
                    "paquete_id" => $request->paquete_id,
                    "tipo_evaluacion_id" => $request->tipo_evaluacion_id,
                    "tipo_atencion" => $request->tipo_atencion,
                    "total" => $empresa_paquete->precio,
                    "subtotal" => round(($empresa_paquete->precio) / 1.18, 2),
                    "igv" => round((($empresa_paquete->precio) / 1.18) * 0.18, 2),
                ]);
                foreach ($servicios as $services) {
                    $atencion_servicio = AtencionServicio::create([
                        "servicio_id" => $services["id"],
                        "atencion_id" => $atencion->id,
                        "estado_registro" => "A",
                    ]);
                }
            }
            return response()->json(["resp" => "ingreso correcto"], 201);
        } catch (Exception $e) {
            return response()->json(["resp" => $e], 500);
        }
    }

    /**
     *  Enviar un grupo de personal de empresa para atenderse a una clinica
     *  @OA\Post (
     *      path="/api/atencion/enviarpacientes",
     *      summary="Enviar un grupo de personal de empresa para atenderse a una clinica",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Atencion"},
     *      @OA\Parameter(description="ID de personal",
     *          @OA\Schema(type="number"),name="id", in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="ID de personal",
     *          @OA\Schema(type="number"),name="id", in="query",required= false,example=1
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="pacientes", type="array",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id", type="number", example=1),
     *                      ),
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id", type="number", example=2),
     *                      ),
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Grupo enviado exitosamente"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No existe personal con el id: 2"),
     *          )
     *      ),
     *  )
     */


    public function enviarpacientes(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $pacientes = $request->pacientes;
            foreach ($pacientes as $paciente) {
                $personal = EmpresaPersonal::find($paciente['id']);
                if (!$personal) return response()->json(["error" => "No existe personal con el id: " . $paciente['id']], 500);
                $rol = Rol::find($paciente->rol_id);
                $hoja_ruta = HojaRuta::updateOrCreate([
                    'empresa_personal_id'=>$personal->id,
                    'clinica_id'=>$rol->clinica_id
                ],[
                    'perfil_tipo_id'=>$request->perfil_tipo_id
                ]);
                $hoja_ruta_detalle = HojaRutaDetalle::updateOrCreate([
                    'hoja_ruta_id'=>$hoja_ruta->id
                ],[
                    'clinica_servicio'=>$request->clinica_servicio,
                    'estado_ruta_id'=>0
                ]);
                Paciente::updateOrCreate([
                    'empresa_personal_id' => $personal->id,
                    'persona_id'=>$personal->persona_id
                ], [
                    'hoja_ruta_id'=> $hoja_ruta->id,
                    'estado_atencion' => 0,
                    'clinica_id'=>$rol->clinica_id
                ]);
            }
            DB::commit();
            return response()->json(["resp" => "Grupo enviado exitosamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }
    public function getAtencionEmpresa()
    {
        $usuario = User::with('roles')->find(auth()->user()->id);
        $empresa = Empresa::where('ruc', $usuario->username)->first();
        $atenciones = Atencion::with(["atencion_servicio.servicio", "trabajador.persona.tipo_documento", "tipo_evaluacion"])->where("empresa_id", $empresa->id)->get();
        return response()->json(["data" => $atenciones, "size" => count($atenciones)]);
    }
    public function getAtenciones()
    {
        $usuario = User::with('roles')->find(auth()->user()->id);
        $atenciones = Atencion::with(["atencion_servicio.servicio", "trabajador.persona.tipo_documento"])->where('estado_atencion', '!=', 1)->where('estado_registro', 'A')->get();
        return response()->json(["data" => $atenciones, "size" => count($atenciones)]);
    }
    public function import(Request $request)
    {
        if ($this->admin(3, '/atenciones') == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        //$user_rol=UserRol::where('user_id',auth()->user()->id)->where('rol_id',1)->first();
        $usuario = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $empresa = Empresa::where("ruc", $usuario->persona->numero_documento)->first();
        if ($empresa) {
            $empresa = $empresa;
        }
        //$empresa = Empresa::where('user_rol_id',$user_rol->id)->first();
        $servicios = Servicio::select('servicio.id')
            ->join('servicio_hospital', 'servicio.id', 'servicio_hospital.servicio_id')
            ->join('servicio_producto', 'servicio_hospital.id', 'servicio_producto.servicio_hospital_id')
            ->join('producto', 'servicio_producto.producto_id', 'producto.id')
            ->join('producto_paquete', 'producto.id', 'producto_paquete.producto_id')
            ->join('paquete', 'producto_paquete.paquete_id', 'paquete.id')
            ->where('servicio.estado_registro', 'A')
            ->where('paquete.id', $request->paquete_id)
            ->get();

        $rows = Excel::toCollection(new AtencionImport, $request->file('file'));

        foreach ($rows[0] as $row) {
            ini_set('max_execution_time', 300);
            if (strtoupper($row['tipo_documento']) == "DNI") {
                $tipo_documento_id = 1;
            }
            if (strtoupper($row['tipo_documento']) == "PASAPORTE") {
                $tipo_documento_id = 4;
            }
            if (strtoupper($row['tipo_documento']) == "CE") {
                $tipo_documento_id = 3;
            }
            $persona = Persona::firstOrCreate(
                [
                    "tipo_documento_id" => $tipo_documento_id,
                    "numero_documento" => $row['dni'],
                ],
                [
                    "nombres" => $row['nombre'],
                    "apellido_paterno" => $row['apellido_paterno'],
                    "apellido_materno" => $row['apellido_materno'],
                ]
            );
            $historia_clinica = HistoriaClinica::firstOrCreate(
                [
                    "persona_id" => $persona->id,
                ],
                [
                    "fecha_emision" => date('Y-m-d'),
                ]
            );
            /*$usuario = User::firstOrCreate([
                "username"=>$persona->numero_documento,
            ],[
                "password"=>$persona->numero_documento,
                "estado_registro"=>"A"
            ]);
            $usuario_rol=UserRol::updateOrCreate([
                "user_id"=>$usuario->id,
                "rol_id"=>3
            ],[
                "estado_registro"=>"A"
            ]);
            */
            $trabajador = Trabajador::updateOrCreate([
                //"user_rol_id"=>$usuario_rol->id,
                "empresa_id" => $empresa->id,
                "persona_id" => $persona->id,
            ], [
                "estado_registro" => "A",
                //"estado_trabajador"=>null,
            ]);

            /*$hc_trabajador=HCTrabajador::firstOrCreate([
                "trabajador_id"=>$trabajador->id,
                "historia_clinica_id"=>$historia_clinica->id,
            ],[]);*/
            $empresa_paquete = EmpresaPaquete::where('paquete_id', $request->paquete_id)->first();
            $trabajador_atencion = Atencion::create([
                "trabajador_id" => $trabajador->id,
                "fecha_emision" => date('Y-m-d'),
                "estado_atencion" => 0,
                "estado_registro" => "A",
                "empresa_id" => $empresa->id,
                "fecha_atencion" => $request->fecha_atencion,
                "paquete_id" => $request->paquete_id,
                "tipo_evaluacion_id" => $request->tipo_evaluacion_id,
                "tipo_atencion" => $request->tipo_atencion,
                "total" => $empresa_paquete->precio,
                "subtotal" => ($empresa_paquete->precio) / 1.18,
                "igv" => (($empresa_paquete->precio) / 1.18) * 0.18,
            ]);
            foreach ($servicios as $servicio) {
                $atencion_servicio = AtencionServicio::create([
                    "servicio_id" => $servicio['id'],
                    "atencion_id" => $trabajador_atencion->id,
                    "estado_registro" => "A",
                ]);
            }
        }
        return response()->json(["resp" => "atenciones creadas"]);
    }
    public function getAtencionesFacturacion()
    {
        //$atenciones = Atencion::select(['empresa_id','atencion.estado_atencion'])->with('empresa')->groupBy('empresa_id')->where('estado_atencion','0')->get(); 
        /*$atenciones = \DB::table('atencion')
        ->select(\DB::raw("sum('id') as Total, empresa_id as Categoria"))
        ->groupBy('empresa_id')
        ->get();*/
        //$atenciones = Atencion::select('atencion.id','empresa.razon_social','empresa.ruc','tipo_documento.nombre','atencion.estado_atencion',\DB::raw('count(*) as cantidad_atencion'))
        //$atenciones = \DB::table('atencion')->selectRaw('empresa_id,count(*) as cantidad_atencion,empresa.razon_social as razon_social')
        //->with('empresa')
        $atenciones = Atencion::selectRaw('*,count(*) as cantidad_atencion,sum(total) as total,sum(subtotal) as subtotal,sum(igv) as igv')
            ->with('empresa.tipo_documento')
            ->where('estado_atencion', 0)
            ->groupBy('atencion.empresa_id')
            ->get();
        return response()->json(["data" => $atenciones, "size" => count($atenciones)]);
    }
    public function getAtencionesLiquidacionEmpresa($IdEmpresa)
    {
        //$atenciones = Atencion::select(['empresa_id','atencion.estado_atencion'])->with('empresa')->groupBy('empresa_id')->where('estado_atencion','0')->get(); 
        /*$atenciones = \DB::table('atencion')
        ->select(\DB::raw("sum('id') as Total, empresa_id as Categoria"))
        ->groupBy('empresa_id')
        ->get();*/
        //$atenciones = Atencion::select('atencion.id','empresa.razon_social','empresa.ruc','tipo_documento.nombre','atencion.estado_atencion',\DB::raw('count(*) as cantidad_atencion'))
        //$atenciones = \DB::table('atencion')->selectRaw('empresa_id,count(*) as cantidad_atencion,empresa.razon_social as razon_social')
        //->with('empresa')
        /*$atenciones = Atencion::with('empresa.tipo_documento','trabajador.persona.tipo_documento','atencion_servicio.servicio')
        ->where('estado_atencion',0)
        ->where('empresa_id',$IdEmpresa)
        ->get();
        return response()->json(["data"=>$atenciones,"size"=>count($atenciones)]);          */
        $empresa = Empresa::with('atenciones.trabajador.persona.tipo_documento', 'atenciones.atencion_servicio.servicio', 'atenciones.paquete')->find($IdEmpresa);
        return response()->json($empresa);
    }
}
