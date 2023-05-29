<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRol;
use App\Models\Empresa;
use App\Models\Atencion;
use App\Models\Trabajador;
use App\Models\HistoriaClinica;
use App\Models\HCTrabajador;
use App\Models\Servicio;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AtencionImport;
use App\Models\AtencionServicio;
use App\Models\FichaOcupacional;
use App\Models\FichaPsicologicaOcupacional;
use App\Models\FichaEmpresa;
use App\Models\FichaTrabajador;
use App\Models\Persona;
use App\User;

class AtencionController extends Controller
{
    public function get(){
        $user_rol=UserRol::where('user_id',auth()->user()->id)->where('rol_id',1)->first();
        $empresa = Empresa::where('user_rol_id',$user_rol->id)->first();
        $atencion = Atencion::with(['trabajador.empresa','trabajador.sucursal','trabajador.subarea','trabajador.persona','empresa'])->where('empresa_id',$empresa->id)->get();
        return response()->json(["resp"=>$atencion,"size"=>count($atencion)]);
    }

    public function createSubarea(Request $request){
        $user_rol=UserRol::where('user_id',auth()->user()->id)->where('rol_id',1)->first();
        $empresa = Empresa::where('user_rol_id',$user_rol->id)->first();
        $trabajadores = Trabajador::where('subarea_id',$request->subarea_id)->where("empresa_id",$empresa->id)->where('estado_registro','A')->get();
        $servicios = Servicio::select('servicio.id')
        ->join('servicio_producto','servicio.id','servicio_producto.servicio_id')
        ->join('producto','servicio_producto.producto_id','producto.id')
        ->join('producto_paquete','producto.id','producto_paquete.producto_id')
        ->join('paquete','producto_paquete.paquete_id','paquete.id')
        ->where('servicio.estado_registro','A')
        ->where('paquete.id',$request->paquete_id)
        ->get();
        foreach($trabajadores as $trabajador){
            $historia_clinica=HistoriaClinica::firstOrCreate([
                "persona_id"=>$trabajador['persona_id'],
                "fecha_emision"=>date('Y-m-d'),
            ],[]);
            /*$hc_trabajador=HCTrabajador::firstOrCreate([
                "trabajador_id"=>$trabajador['id'],
                "historia_clinica_id"=>$historia_clinica->id,
            ][]);*/
            $trabajador_atencion = Atencion::create([
                "trabajador_id"=>$trabajador['id'],
                "fecha_emision"=>date('Y-m-d'),
                "estado_atencion"=>0,
                "estado_registro"=>"A",
                "empresa_id"=>$empresa->id,
            ]);
            foreach($servicios as $servicio){
                $atencion_servicio = AtencionServicio::create([
                    "servicio_id"=>$servicio['id'],
                    "atencion_id"=>$trabajador_atencion->id,
                    "estado_registro"=>"A",
                ]);
            }

        }
        return response()->json(["resp"=>"atenciones creadas por subareas"]);

    }
    public function createTrabajadores(Request $request){
        $user_rol=UserRol::where('user_id',auth()->user()->id)->where('rol_id',1)->first();
        $empresa = Empresa::where('user_rol_id',$user_rol->id)->first();
        $servicios = Servicio::select('servicio.id')
        ->join('servicio_producto','servicio.id','servicio_producto.servicio_id')
        ->join('producto','servicio_producto.producto_id','producto.id')
        ->join('producto_paquete','producto.id','producto_paquete.producto_id')
        ->join('paquete','producto_paquete.paquete_id','paquete.id')
        ->where('servicio.estado_registro','A')
        ->where('paquete.id',$request->paquete_id)
        ->get();
        $trabajadores=$request->trabajadores;
        foreach($trabajadores as $trabajador){
            $trabajador_historia=Trabajador::find($trabajador['id']);
            $historia_clinica=HistoriaClinica::firstOrCreate([
                "persona_id"=>$trabajador_historia->persona_id,
                "fecha_emision"=>date('Y-m-d'),
            ],[]);
            /*$hc_trabajador=HCTrabajador::firstOrCreate([
                "trabajador_id"=>$trabajador['id'],
                "historia_clinica_id"=>$historia_clinica->id,
            ][]);*/
            $trabajador_atencion = Atencion::create([
                "trabajador_id"=>$trabajador['trabajador_id'],
                "fecha_emision"=>date('Y-m-d'),
                "estado_atencion"=>0,
                "estado_registro"=>"A",
                "empresa_id"=>$empresa->id,
            ]);
            foreach($servicios as $servicio){
                $atencion_servicio = AtencionServicio::create([
                    "servicio_id"=>$servicio['id'],
                    "atencion_id"=>$trabajador_atencion->id,
                    "estado_registro"=>"A",
                ]);
            }

        }
        return response()->json(["resp"=>"atenciones creadas por trabajadores"]);

    }
    public function getFichaOcupacional($ficha_ocupacional_id)
    {
        $ficha_ocupacional = FichaOcupacional::with('ficha_trabajador','ficha_empresa','signos_vitales','antecedente_familiar.familiar','antecedente_familiar.antecedente_familiar_detalle.patologico','antecedente_personal.patologico','habitos.habitos_nocivos_detalles.habito_nocivo','habitos.habitos_nocivos_detalles.frecuencia','evaluacion_medica')->where('estado_registro','A')->find($ficha_ocupacional_id);
        return response()->json($ficha_ocupacional);
    }
    public function getFichaPsicologicaOcupacional($ficha_psicologica_ocupacional_id)
    {
        $ficha_psicologica_ocupacional = FichaPsicologicaOcupacional::with('ficha_trabajador','ficha_empresa','motivo_evaluacion','datos_ocupacionales.principales_riesgos','datos_ocupacionales.medidas_seguridad','anteriores_empresas','observaciones_conductas.presentacion','observaciones_conductas.postura','observaciones_conductas.ritmo','observaciones_conductas.tono','observaciones_conductas.articulacion','observaciones_conductas.tiempo','observaciones_conductas.espacio','procesos_cognitivos.memoria','procesos_cognitivos.inteligencia')->where('estado_registro','A')->find($ficha_psicologica_ocupacional_id);
        return response()->json($ficha_psicologica_ocupacional);
    }
    public function createPrueba(Request $request)
    {
        $empresa= Empresa::find(1);
        $trabajadores = $request->trabajadores;
            foreach($trabajadores as $trabajador){
                $trabaja = Trabajador::with('persona.tipo_documento')->find($trabajador['trabajador_id']);
                $historia_clinica=HistoriaClinica::firstOrCreate(
                    [
                        "persona_id"=>$trabaja->persona->id,

                    ],
                    [
                        "fecha_emision"=>date("Y-m-d"),
                    ]);
                $ficha_ocupacional=FichaOcupacional::firstOrCreate(
                    [
                        "historia_clinica_id"=>$historia_clinica->id,
                    ],
                    [
                        "estado_atencion"=>1,
                    ]);
                $ficha_psicologica_ocupacional=FichaPsicologicaOcupacional::firstOrCreate(
                    [
                        "historia_clinica_id"=>$historia_clinica->id,
                    ],
                    [
                        "fecha_emision"=>date("Y-m-d"),
                        "estado_registro"=>"A",
                    ]);
                $ficha_empresa =FichaEmpresa::firstOrCreate(
                    [
                        "empresa_id"=>$empresa->id,
                        "ficha_ocupacional_id"=>$ficha_ocupacional->id,
                        "ficha_psicologica_ocupacional_id"=>$ficha_psicologica_ocupacional->id,
                    ],
                    [
                        "razon_social"=>$empresa->razon_social,
                    ]);
                $ficha_trabajador= FichaTrabajador::firstOrCreate(
                    [
                        "ficha_ocupacional_id"=>$ficha_ocupacional->id,
                        "ficha_psicologica_ocupacional_id"=>$ficha_psicologica_ocupacional->id,
                        "trabajador_id"=>$trabaja->id,
                    ],
                    [
                        "nombres"=>$trabaja->persona->nombres,
                        "apellido_paterno"=>$trabaja->persona->apellido_paterno,
                        "apellido_materno"=>$trabaja->persona->apellido_materno,
                        "fecha_nacimiento"=>$trabaja->persona->fecha_nacimiento,
                        "edad"=>$request->edad,
                        "numero_documento"=>$trabaja->persona->numero_documento,
                        "tipo_documento_id"=>$trabaja->persona->tipo_documento_id,
                        "hijos_vivos"=>$trabaja->persona->hijos_vivos,
                        "dependientes"=>$trabaja->persona->dependientes,
                        "direccion"=>$trabaja->persona->direccion,
                        "distrito_id"=>$trabaja->persona->distrito_id,
                        "residencia_lugar_trabajo"=>$trabaja->persona->residencia_lugar_trabajo,
                        "tiempo_residencia"=>$trabaja->persona->tiempo_residencia,
                        "grado_instruccion_id"=>$trabaja->persona->grado_instruccion_id,
                        "telefono"=>$trabaja->persona->telefono,
                        "email"=>$trabaja->persona->email,
                        "foto"=>$trabaja->persona->foto,
                        "estado_registro"=>"A",
                    ]);
            }
            return response()->json(["resp"=>"atenciones creadas correctamente"]);
    }
    public function import(Request $request){
        $user_rol=UserRol::where('user_id',auth()->user()->id)->where('rol_id',1)->first();
        $empresa = Empresa::where('user_rol_id',$user_rol->id)->first();
        $servicios = Servicio::select('servicio.id')
        ->join('servicio_producto','servicio.id','servicio_producto.servicio_id')
        ->join('producto','servicio_producto.producto_id','producto.id')
        ->join('producto_paquete','producto.id','producto_paquete.producto_id')
        ->join('paquete','producto_paquete.paquete_id','paquete.id')
        ->where('servicio.estado_registro','A')
        ->where('paquete.id',$request->paquete_id)
        ->get();
        $rows = Excel::toCollection(new AtencionImport,$request->file('file'));
        foreach($rows[0] as $row){
            ini_set('max_execution_time', 300);
            if(strtoupper($row['tipo_documento'])=="DNI"){
                $tipo_documento_id=1;
            }
            if(strtoupper($row['tipo_documento'])=="PASAPORTE"){
                $tipo_documento_id=4;
            }
            if(strtoupper($row['tipo_documento'])=="CE"){
                $tipo_documento_id=3;
            }
            $persona = Persona::firstOrCreate(
            [
                "tipo_documento_id"=>$tipo_documento_id,
                "numero_documento"=>$row['dni'],
            ],
            [
                "nombres"=>$row['nombre'],
                "apellido_paterno"=>$row['apellido_paterno'],
                "apellido_materno"=>$row['apellido_materno'],
            ]);

            $usuario = User::firstOrCreate([
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
            $trabajador=Trabajador::updateOrCreate([
                "user_rol_id"=>$usuario_rol->id,
                "empresa_id"=>$empresa->id,
                "persona_id"=>$persona->id,
            ],[
                "estado_registro"=>"A",
                "estado_trabajador"=>null,
            ]);
            $historia_clinica=HistoriaClinica::firstOrCreate([
                "persona_id"=>$persona->id,
                "fecha_emision"=>date('Y-m-d'),
            ],[]);
            /*$hc_trabajador=HCTrabajador::firstOrCreate([
                "trabajador_id"=>$trabajador->id,
                "historia_clinica_id"=>$historia_clinica->id,
            ],[]);*/
            $trabajador_atencion = Atencion::create([
                "trabajador_id"=>$trabajador->id,
                "fecha_emision"=>date('Y-m-d'),
                "estado_atencion"=>0,
                "estado_registro"=>"A",
                "empresa_id"=>$empresa->id,
            ]);
            foreach($servicios as $servicio){
                $atencion_servicio = AtencionServicio::create([
                    "servicio_id"=>$servicio['id'],
                    "atencion_id"=>$trabajador_atencion->id,
                    "estado_registro"=>"A",
                ]);
            }
        }
        return response()->json(["resp"=>"atenciones creadas"]);
    }
}
