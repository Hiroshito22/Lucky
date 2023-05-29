<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\ClinicaPersonalController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\PersonaController;
use App\Models\Acceso;
use App\Models\AccesoRol;
use App\Models\Bregma;
use App\Models\Celular;
use App\Models\CelularInstitucion;
use App\Models\Clinica;
use App\Models\ClinicaPaquete;
use App\Models\ClinicaPersonal;
use App\Models\Contrato;
use App\Models\Correo;
use App\Models\CorreoInstitucion;
use App\Models\Empresa;
use App\Models\Hospital;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\TipoCliente;
use App\Models\UserRol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use TheSeer\Tokenizer\Exception;

use function PHPUnit\Framework\returnSelf;

class ClinicaController extends Controller
{
    private $CPersonal;
    private $Empresa;
    private $Persona;
    private $Contrato;
    public function __construct(ClinicaPersonalController $CPersonal,EmpresaController $Empresa, PersonaController $Persona, ContratoController $Contrato)
    {
        $this->Persona = $Persona;
        $this->Empresa = $Empresa;
        $this->CPersonal = $CPersonal;
        $this->Contrato = $Contrato;
    }

    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == "/clinicas") {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    public function index()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();
        $clinica = Clinica::with(['user_rol', 'tipo_documento', 'distrito.provincia.departamento'])->where('hospital_id', $hospital->id)->where('estado_registro', '=', 'A')->get();
        return response()->json(['data' => $clinica, 'size' => count($clinica)], 200);
    }
    /**
     *  Crear clinica.
     *  @OA\Post(
     *      path="/api/clinicas/create",
     *      summary="Crear Clinica",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Bregma - clínica"},
     *      @OA\Parameter(description="Tipo de cliente", @OA\Schema(type="number"), name="tipo_cliente_id", in="query", required = false, example=1),
     *      @OA\Parameter(description="Id del distrito", @OA\Schema(type="number"), name="distrito_id", in="query", required = false, example=1),
     *      @OA\Parameter(description="Nombre de Razón Social", @OA\Schema(type="stringr"), name="razon_social", in="query", required = false, example="Razon Social"),
     *      @OA\Parameter(description="Número de documento de identificación", @OA\Schema(type="string"), name="numero_documento", in="query", required = false, example="23456789"),
     *      @OA\Parameter(description="Nombre del responsable", @OA\Schema(type="string"), name="responsable", in="query", required = false, example="Responsable"),
     *      @OA\Parameter(description="Nombre comercial de la clinica", @OA\Schema(type="string"), name="nombre_comercial", in="query", required = false, example="Nombre comercial"),
     *      @OA\Parameter(description="Latitud de la clinica", @OA\Schema(type="string"), name="latitud", in="query", required = false, example="19° 25′ 42″ N"),
     *      @OA\Parameter(description="Longitud de la clinica", @OA\Schema(type="string"), name="longitud", in="query", required = false, example="99° 7′ 39″ O"),
     *      @OA\Parameter(description="Direccion de la clinica", @OA\Schema(type="string"), name="direccion", in="query", required = false, example="Av. Cantogrande 415"),
     *      @OA\Parameter(description="Logo de la clinica", @OA\Schema(type="file"), name="logo", in="query", required = false, example="foto.jpg"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="distrito_id", type="number"),
     *                      @OA\Property(property="razon_social", type="string"),
     *                      @OA\Property(property="numero_documento", type="string"),
     *                      @OA\Property(property="responsable", type="string"),
     *                      @OA\Property(property="nombre_comercial", type="string"),
     *                      @OA\Property(property="latitud", type="string"),
     *                      @OA\Property(property="longitud", type="string"),
     *                      @OA\Property(property="direccion", type="string"),
     *                      @OA\Property(property="logo", type="file"),
     *                  ),
     *                  example={
     *                      "tipo_cliente_id":1,
     *                      "tipo_documento_id":1,
     *                      "distrito_id":1,
     *                      "razon_social":"MOE SIMPLER",
     *                      "numero_documento":"01425486",
     *                      "responsable":"Responsable",
     *                      "nombre_comercial":"Company",
     *                      "latitud":null,
     *                      "longitud":null,
     *                      "direccion":"Av. Cantogrande 415",
     *                      "logo":"0"
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Clinica Creada correctamente"),
     *              @OA\Property(property="clinica_id", type="string", example="1"),
     *              @OA\Property(property="contrato_id", type="string", example="1"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Ya existe clinica con el numero de documento"),
     *          )
     *      ),
     *  )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existe_tipo_cliente = TipoCliente::find($request->tipo_cliente_id);
            $existe_numero_documento = User::where('username', $request->numero_documento)->where('estado_registro', 'A')->first();
            $reglas = [
                'tipo_cliente_id' => 'required',
                'numero_documento' => 'required',
                'razon_social' => 'required',
                'responsable' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if (!$existe_tipo_cliente) return response()->json(["error" => "No existe el tipo de cliente"]);
            if ($existe_numero_documento) return response()->json(["error" => "Ya existe otro registro con el numero de documento"]);
            $usuario = User::with('roles')->find(auth()->user()->id);
            $bregma = Bregma::where('numero_documento', $usuario->username)->first();
            $clinica = Clinica::updateOrCreate(
                [
                    'tipo_documento_id' => 2,
                    'numero_documento' => $request->numero_documento,
                ],
                [
                    'razon_social' => $request->razon_social === "null" ? null : $request->razon_social,
                    'nombre_comercial' => $request->nombre_comercial === "null" ? null : $request->nombre_comercial,
                    'responsable' => $request->responsable === "null" ? null : $request->responsable,
                    'distrito_id' => $request->distrito_id === "null" ? null : $request->distrito_id,
                    'direccion' => $request->direccion === "null" ? null : $request->direccion,
                    'latitud' => $request->latitud === "null" ? null : $request->latitud,
                    'longitud' => $request->longitud === "null" ? null : $request->longitud,
                    'estado_registro' => 'A'
                ]
            );
            $persona = $this->Persona->store_institucion($request, null, $clinica->id, null);
            $usuario = User::updateOrCreate(
                [
                    "username" => $request->numero_documento,
                ],
                [
                    "persona_id" => $persona->id,
                    "password" => $request->numero_documento,
                    "estado_registro" => "A"
                ]
            );

            $rol = Rol::updateOrCreate(
                [
                    "nombre" => "Administrador Clinica",
                    "tipo_acceso" => 2,
                    "clinica_id" => $clinica->id
                ],
                [
                    "estado_registro" => "AD"
                ]
            );

            $usuario_rol = UserRol::updateOrCreate(
                [
                    "user_id" => $usuario->id,
                    "rol_id" => $rol->id,
                ],
                [
                    "tipo_rol" => 1,
                    "estado_registro" => "A"
                ]
            );
            $accesos = Acceso::where('tipo_acceso', 2)->where('parent_id', null)->get();
            foreach ($accesos as $acceso) {
                $acceso_rol = AccesoRol::firstOrCreate(
                    [
                        "acceso_id" => $acceso["id"],
                        "rol_id" => $rol->id,
                    ],
                    []
                );
            }
            $contrato = Contrato::updateOrCreate([
                'clinica_id' => $clinica->id
            ], [
                'tipo_cliente_id' => $request->tipo_cliente_id === "null" ? null : $request->tipo_cliente_id,
                'bregma_id' => $bregma->id,
                'empresa_id' => null,
                'estado_registro' => 'A'
            ]);

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->storeAs('public/clinica', $clinica->id . '-' . $request->numero_documento . '.' . $request->logo->extension());
                $image = $clinica->id . '-' . $request->numero_documento . '.' . $request->logo->extension();
            } else {
                $image = null;
            }
            $clinica->logo = $image;
            $clinica->save();
            DB::commit();
            return response()->json(["resp" => "Clinica Creada correctamente","clinica_id"=>$clinica->id,"contrato_id"=>$contrato->id]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }

    /**
     * Actualizar datos de Clínica
     * @OA\Put (
     *     path="/api/clinicas/update/{idClinica}",
     *     summary="Actualizar datos de clínica teniendo como parametro el id de la clínica",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Bregma - clínica"},
     *      @OA\Parameter(description="ID de la clínica",
     *          @OA\Schema(type="number"), name="idClinica", in="path", required= true, example=2),
     *      @OA\Parameter(description="Tipo de cliente",
     *          @OA\Schema(type="number"), name="tipo_cliente_id", in="query", required = false, example=1),
     *      @OA\Parameter(description="ID del tipo del documento",
     *          @OA\Schema(type="number"), name="tipo_documento_id", in="query", required= false, example=1),
     *      @OA\Parameter(description="ID del distrito",
     *          @OA\Schema(type="number"), name="distrito_id", in="query", required= false, example=1),
     *      @OA\Parameter(description="Numero del documento",
     *          @OA\Schema(type="string"), name="numero_documento", in="query", required= false, example="01425486"),
     *      @OA\Parameter(description="Nombre de razon social",
     *          @OA\Schema(type="string"), name="razon_social", in="query", required= false, example="MAR OCEANO"),
     *      @OA\Parameter(description="Nombre Comercial",
     *          @OA\Schema(type="string"), name="nombre_comercial", in="query", required= false, example="Asociación"),
     *      @OA\Parameter(description="Responsable",
     *          @OA\Schema(type="string"), name="responsable", in="query", required= false, example="Pepito"),
     *      @OA\Parameter(description="Latitud de ubicacion de clínica",
     *          @OA\Schema(type="string"), name="latitud", in="query", required= false, example="19° 25′ 42″ N"),
     *      @OA\Parameter(description="Longitud de ubicacion de Clínica",
     *          @OA\Schema(type="string"),name="longitud", in="query", required= false, example="99° 7′ 39″ O"),
     *      @OA\Parameter(description="Número de celular",
     *          @OA\Schema(type="number"), name="celular", in="query", required= false,example=999999999),
     *      @OA\Parameter(description="Correo electronico",
     *          @OA\Schema(type="string"), name="correo", in="query", required= false, example="clinica3@gmail.com"),
     *      @OA\Parameter(description="Direccion de la clinica",
     *          @OA\Schema(type="string"), name="direccion", in="query", required = false, example="Av. Cantogrande 415"),
     *      @OA\Parameter(description="Logo de la clinica",
     *          @OA\Schema(type="file"), name="logo", in="query", required = false, example="foto.jpg"),
     *
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="tipo_cliente_id", type="number"),
     *                      @OA\Property(property="tipo_documento_id", type="number"),
     *                      @OA\Property(property="distrito_id", type="number"),
     *                      @OA\Property(property="numero_documento", type="string"),
     *                      @OA\Property(property="razon_social", type="string"),
     *                      @OA\Property(property="nombre_comercial", type="string"),
     *                      @OA\Property(property="responsable", type="string"),
     *                      @OA\Property(property="latitud", type="string"),
     *                      @OA\Property(property="longitud", type="string"),
     *                      @OA\Property(property="celular", type="number"),
     *                      @OA\Property(property="correo", type="string"),
     *                      @OA\Property(property="direccion", type="string"),
     *                      @OA\Property(property="logo", type="file"),
     *                  ),
     *                  example={
     *                      "tipo_cliente_id":1,
     *                      "tipo_documento_id":1,
     *                      "distrito_id":1,
     *                      "numero_documento":"88776655",
     *                      "razon_social":"MAR OCEANO",
     *                      "nombre_comercial":"Asociación",
     *                      "responsable":"Pepito",
     *                      "latitud":null,
     *                      "longitud":null,
     *                      "celular":null,
     *                      "correo":null,
     *                      "direccion":"Av. Cantogrande 415",
     *                      "logo":""
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Clínica actualizada correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen registro con ese id"),
     *          )
     *      ),
     *      @OA\Response(response=402, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe el tipo de cliente"),
     *          )
     *      ),
     *      @OA\Response(response=403, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Ya existe otro registro con el número de documento"),
     *          )
     *      ),
     *      @OA\Response(response=404, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El número de celular ya se encuentra registrado"),
     *          )
     *      ),
     *      @OA\Response(response=405, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El correo ya se encuentra registrado"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $contrato_id)
    {
        DB::beginTransaction();
        try {
            $contrato = Contrato::find($contrato_id);
            if (!$contrato) return response(["error" => "No existe contrato con ese id"], 400);
            $clinica = Clinica::find($contrato->clinica_id);
            $usuario = User::with('persona')->where('username', $clinica->numero_documento)->where('estado_registro', 'A')->first();
            $persona  = Persona::find($usuario->persona->id);
            $existe_tipo_cliente = TipoCliente::find($request->tipo_cliente_id);
            if (!$existe_tipo_cliente) return response()->json(["error" => "No existe un tipo de cliente con ese id"]);
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->storeAs('public/clinica', $clinica->id . '-' . $request->numero_documento . '.' . $request->logo->extension());
                $image = $clinica->id . '-' . $request->numero_documento . '.' . $request->logo->extension();
                $clinica->logo = $image;
                $clinica->save();
            }
            $clinica->fill([
                'razon_social' => $request->razon_social === "null" ? null : $request->razon_social,
                'nombre_comercial' => $request->nombre_comercial === "null" ? null : $request->nombre_comercial,
                'responsable' => $request->responsable === "null" ? null : $request->responsable,
                'distrito_id' => $request->distrito_id === "null" ? null : $request->distrito_id,
                'direccion' => $request->direccion === "null" ? null : $request->direccion,
                'latitud' => $request->latitud === "null" ? null : $request->latitud,
                'longitud' => $request->longitud === "null" ? null : $request->longitud,
            ])->save();
            $contrato->fill([
                "tipo_cliente_id" => $request->tipo_cliente_id,
                "estado_contrato" => $request->estado_contrato
            ])->save();
            CelularInstitucion::updateOrCreate(
                [
                    'clinica_id' => $clinica->id
                ],
                [

                    'celular' => $request->celular === "null" ? null : $request->celular,
                ]
            )->save();
            CorreoInstitucion::updateOrCreate(
                [
                    'clinica_id' => $clinica->id
                ],
                [
                    'correo' => $request->correo === "null" ? null : $request->correo,
                ]
            )->save();
            DB::commit();
            return response()->json(["resp" => "Clinica actualizada correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error", "error" => $e], 500);
        }
        // if ($this->admin() == false) {
        //     return response()->json(["resp" => "no tiene accesos"]);
        // }

    }
    public function updatebylogin(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->find(auth()->user()->id);
            //return response()->json($usuario->user_rol[0]->rol);
            $clinica = Clinica::find($usuario->user_rol[0]->rol->clinica_id);
            if (!$clinica) return response(["error" => "El rol de usuario logeado no posee una clinica"], 400);
            $contrato = Contrato::where('clinica_id', $clinica->id)->first();
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->storeAs('public/clinica', $clinica->id . '-' . $request->numero_documento . '.' . $request->logo->extension());
                $image = $clinica->id . '-' . $request->numero_documento . '.' . $request->logo->extension();
                $clinica->logo = $image;
                $clinica->save();
            }
            $clinica->fill([
                'razon_social' => $request->razon_social === "null" ? null : $request->razon_social,
                'nombre_comercial' => $request->nombre_comercial === "null" ? null : $request->nombre_comercial,
                'responsable' => $request->responsable === "null" ? null : $request->responsable,
                'distrito_id' => $request->distrito_id === "null" ? null : $request->distrito_id,
                'direccion' => $request->direccion === "null" ? null : $request->direccion,
                'latitud' => $request->latitud === "null" ? null : $request->latitud,
                'longitud' => $request->longitud === "null" ? null : $request->longitud
            ])->save();
            CelularInstitucion::updateOrCreate(
                [
                    'clinica_id' => $clinica->id
                ],
                [

                    'celular' => $request->celular === "null" ? null : $request->celular,
                ]
            )->save();
            CorreoInstitucion::updateOrCreate(
                [
                    'clinica_id' => $clinica->id
                ],
                [
                    'correo' => $request->correo === "null" ? null : $request->correo,
                ]
            )->save();
            DB::commit();
            return response()->json(["resp" => "Clinica actualizada correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error", "error" => $e], 500);
        }
        // if ($this->admin() == false) {
        //     return response()->json(["resp" => "no tiene accesos"]);
        // }

    }

    /**
     * Eliminar datos de la Clínica
     * @OA\Delete (
     *     path="/api/clinicas/delete/{idClinica}",
     *     summary="Inhabilita el registro Clínica teniendo como parametro el id de la Clínica",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Bregma - clínica"},
     *      @OA\Parameter(
     *          description="Numero de ID del registro de clínica que se desea eliminar",
     *          @OA\Schema(type="number"),
     *          name="idClinica",
     *          in="path",
     *          required= true,
     *          example=2
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Se elimino la clinica correctamente"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen archivos con ese id"),
     *          ),
     *      )
     * )
     */

    public function destroy($clinica_id)
    {
        DB::beginTransaction();
        try {
            // if ($this->admin() == false) {
            //     return response()->json(["resp" => "no tiene accesos"]);
            // }

            $clinica = Clinica::find($clinica_id);

            if (!$clinica_id) return response()->json(["error" => "No existen archivos con ese id"], 400);
            $contrato_emp = Contrato::where('clinica_id', $clinica->id)->where('bregma_id',null)->get();

            $empresas = Empresa::where('id',$contrato_emp[0]->empresa_id)->get();

            $usuario = User::with('user_rol.rol')->where('username', $clinica->numero_documento)->first();
            $persona  = Persona::find($usuario->persona->id);
            $trabajadores = ClinicaPersonal::where('clinica_id', $clinica->id)->get();
            // $user_rol = UserRol::find($usuario->user_rol[0]->id);

            foreach ($trabajadores as $trabajador) {
                $this->CPersonal->delete($trabajador->id);
            }
            foreach ($empresas as $empresa) {
                $this->Empresa->destroy($empresa->id);
            }
            $clinica->fill([
                'estado_registro' => 'I'
            ])->save();

            $contrato = Contrato::where('clinica_id', $clinica->id)->where('empresa_id',null)->first();
            if(!$contrato) return response()->json(["resp" => "error elimino la clinica correctamente"]);

            $contrato->fill([
                'estado_registro' => 'I'
            ])->save();

            $usuario->fill([
                'estado_registro' => 'I'
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Se elimino la clinica correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }
    public function activar($clinica_id)
    {
        DB::beginTransaction();
        try {

            $clinica = Clinica::find($clinica_id);
            if (!$clinica_id) return response()->json(["error" => "No existen alguna clinica con ese id"], 400);
            $contrato_cli = Contrato::where('clinica_id', $clinica->id)->where('bregma_id',null)->get();

            $empresas = Empresa::with(['contratos'])->where('id',$contrato_cli[0]->empresa_id)->get();

            $usuario = User::with('user_rol.rol')->where('username', $clinica->numero_documento)->first();
            $persona  = Persona::find($usuario->persona->id);
            $trabajadores = ClinicaPersonal::where('clinica_id', $clinica->id)->get();
            // $user_rol = UserRol::find($usuario->user_rol[0]->id);
            foreach ($trabajadores as $trabajador) {
                $this->CPersonal->activar($trabajador->id);
            }
            foreach ($empresas as $empresa) {
                $this->Empresa->active($empresa->id);
            }
            $clinica->fill([
                'estado_registro' => 'A'
            ])->save();
            $contrato = Contrato::where('clinica_id', $clinica->id)->where('empresa_id',null)->first();
            // return response()->json($contrato);
            $contrato->fill([
                'estado_registro' => 'A'
            ])->save();
            $usuario->fill([
                'estado_registro' => 'A'
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Se activo la clinica correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }

    /**
     *  Muestra todos los datos de una Clínica
     *  @OA\Get (
     *      path="/api/clinicas/get/{idClinica}",
     *      summary="Muestra datos de clínica teniendo como parametro el id de la clínica",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Bregma - clínica"},
     *      @OA\Parameter(description="Id de la Clínica",
     *          @OA\Schema(type="number"),name="idClinica",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=2),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=2),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="razon_social", type="string", example="MOE SIMPLER"),
     *                      @OA\Property(property="numero_documento", type="string", example="01425486"),
     *                      @OA\Property(property="respnsable", type="string", example="Responsable"),
     *                      @OA\Property(property="nombre_comercial", type="string", example="Company"),
     *                      @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                      @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                      @OA\Property(property="direccion", type="string", example="Av. Cantogrande 415"),
     *                      @OA\Property(property="logo", type="file", example=""),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(property="hospital", type="string", example=""),
     *                      @OA\Property(type="object",property="tipo_documento",
     *                          @OA\Property(property="id", type="number", example=2),
     *                          @OA\Property(property="nombre", type="string", example="RUC"),
     *                          @OA\Property(property="codigo", type="string", example=""),
     *                          @OA\Property(property="descripcion", type="string", example="Registro Unico Contribuyente"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                      @OA\Property(type="object",property="distrito",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="distrito", type="string", example="CHACHAPOYAS"),
     *                          @OA\Property(property="provincia_id", type="number", example=1),
     *                          @OA\Property(type="object",property="provincia",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                              @OA\Property(property="departamento_id", type="number", example=1),
     *                              @OA\Property(type="object",property="departamento",
     *                                  @OA\Property(property="id", type="number", example=1),
     *                                  @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                                  ),
     *                              ),
     *                          ),
     *                      ),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen registros con ese id"),
     *          ),
     *      )
     * )
     */
    public function show($clinica_id)
    {
        DB::beginTransaction();
        try {
            // if ($this->admin() == false) {
            //     return response()->json(["resp" => "no tiene accesos"]);
            // }
            if (!$clinica_id) return response()->json(["resp" => "No existen registros con ese id"], 400);
            $clinica = Clinica::with('bregma', 'tipo_documento', 'distrito.provincia.departamento')->find($clinica_id);
            return response()->json($clinica);
            return response()->json(["data" => $clinica], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }

    /**
     * Muestra los datos de la clinica que esta logeada
     * @OA\Get (
     *     path="/api/clinicas/show",
     *     summary="Muestra los datos de la clinica que esta logeada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - clínica"},
     *     @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=2),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=2),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="razon_social", type="string", example="MOE SIMPLER"),
     *                      @OA\Property(property="numero_documento", type="string", example="01425486"),
     *                      @OA\Property(property="respnsable", type="string", example="Responsable"),
     *                      @OA\Property(property="nombre_comercial", type="string", example="Company"),
     *                      @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                      @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                      @OA\Property(property="direccion", type="string", example="Av. Cantogrande 415"),
     *                      @OA\Property(property="logo", type="file", example=""),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(property="hospital", type="string", example=""),
     *                      @OA\Property(type="object", property="bregma",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                          @OA\Property(property="distrito_id", type="number", example=1),
     *                          @OA\Property(property="numero_documento", type="number", example=00000000),
     *                          @OA\Property(property="razon_social", type="string", example=""),
     *                          @OA\Property(property="direccion", type="string", example=""),
     *                          @OA\Property(property="estado_pago", type="string", example=""),
     *                          @OA\Property(property="latitud", type="string", example=""),
     *                          @OA\Property(property="longitud", type="string", example=""),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                      @OA\Property(type="object",property="tipo_documento",
     *                          @OA\Property(property="id", type="number", example=2),
     *                          @OA\Property(property="nombre", type="string", example="RUC"),
     *                          @OA\Property(property="codigo", type="string", example=""),
     *                          @OA\Property(property="descripcion", type="string", example="Registro Unico Contribuyente"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                      @OA\Property(type="object",property="distrito",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="distrito", type="string", example="CHACHAPOYAS"),
     *                          @OA\Property(property="provincia_id", type="number", example=1),
     *                          @OA\Property(type="object",property="provincia",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                              @OA\Property(property="departamento_id", type="number", example=1),
     *                              @OA\Property(type="object",property="departamento",
     *                                  @OA\Property(property="id", type="number", example=1),
     *                                  @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                              ),
     *                          ),
     *                      ),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen registros con ese id"),
     *          ),
     *      )
     *  )
     */
    public function me()
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->find(auth()->user()->id);
            $clinica = Clinica::with(
                'tipo_documento',
                'distrito.provincia.departamento',
                'celulares',
                'correos',
                'detracciones',
                'entidad_pagos.entidad_bancaria'
            )->find($usuario->user_rol[0]->rol->clinica_id);
            return response()->json(["data" => $clinica]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }

    public function getPaquetes($idEmpresa)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquetes = ClinicaPaquete::with(['clinica', 'paquete'])->where('empresa_id', $idEmpresa)->where("estado_registro", 'A')->get();
        return response()->json(["data" => $paquetes, "size" => count($paquetes)]);
    }

    /**
     * Muestra todos los contratos de Clinica
     * @OA\Get (
     *     path="/api/clinicas/contratos/get",
     *     summary="Muestra todos los contratos de Bregma",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - clínica"},
     *     @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_cliente_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=null),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
     *                      @OA\Property(property="fecha_inicio", type="string", example="2002-10-01"),
     *                      @OA\Property(property="fecha_vencimiento", type="string", example="2002-10-01"),
     *                      @OA\Property(property="estado_contrato", type="number", example=0),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object",property="empresa",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="ruc", type="string", example="51245487"),
     *                          @OA\Property(property="razon_social", type="string", example="Empresa Company"),
     *                          @OA\Property(property="responsable", type="string", example="Victor Admin"),
     *                          @OA\Property(property="nombre_comercial", type="string", example="Fanta"),
     *                          @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                          @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                          @OA\Property(property="numero_documento", type="string", example="04521541"),
     *                          @OA\Property(property="tipo_documento_id", type="number", example=2),
     *                          @OA\Property(property="direccion", type="string", example="Av arboles 1213"),
     *                          @OA\Property(property="ubicacion_mapa", type="string", example="example ubicacion"),
     *                          @OA\Property(property="aniversario", type="string", example="04/25"),
     *                          @OA\Property(property="rubro_id", type="number", example=2),
     *                          @OA\Property(property="logo", type="file", example="http://localhost:8000/storage/empresa/Logo"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                          @OA\Property(type="object",property="tipo_documento",
     *                              @OA\Property(property="id", type="number", example=2),
     *                              @OA\Property(property="nombre", type="string", example="RUC"),
     *                              @OA\Property(property="codigo", type="string", example=""),
     *                              @OA\Property(property="descripcion", type="string", example="Registro Unico Contribuyente"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          ),
     *                          @OA\Property(type="object",property="distrito",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="distrito", type="string", example="CHACHAPOYAS"),
     *                              @OA\Property(property="provincia_id", type="number", example=1),
     *                              @OA\Property(type="object",property="provincia",
     *                                  @OA\Property(property="id", type="number", example=1),
     *                                  @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                                  @OA\Property(property="departamento_id", type="number", example=1),
     *                                  @OA\Property(type="object",property="departamento",
     *                                      @OA\Property(property="id", type="number", example=1),
     *                                      @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                                  ),
     *                              ),
     *                          ),
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(property="size", type="number", example=1),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos"),
     *          )
     *      )
     *  )
     */
    public function getcontratos()
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->find(auth()->user()->id);
            $contratos = Contrato::with('empresa.tipo_documento', 'empresa.distrito.provincia.departamento')
                ->where('bregma_id', '=', null)
                ->where('clinica_id','=', $usuario->user_rol[0]->rol->clinica_id, 'and', 'empresa_id', '!=', null)->get();
            if (count($contratos) == 0) return response()->json(["error" => "No hay contratos de clinica"]);
            return response()->json(["data" => $contratos, "size" => count($contratos)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Muestra todos los contratos de clínica que tiene con empresas,
     * @OA\Get (
     *     path="/api/clinica/contratos/empresa/get",
     *     summary="Muestra todos los contratos de clínica que tiene con empresas",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - clínica"},
     *     @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=3),
     *                      @OA\Property(property="tipo_cliente_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=""),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=2),
     *                      @OA\Property(property="bregma_paquete_id", type="number", example=1),
     *                      @OA\Property(property="fecha_inicio", type="string", example="2002-10-01"),
     *                      @OA\Property(property="fecha_vencimiento", type="string", example="2002-10-01"),
     *                      @OA\Property(property="estado_contrato", type="number", example=0),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="empresas",
     *                        @OA\Items(type="object",
     *                            @OA\Property(property="id",type="number",example="1"),
     *                            @OA\Property(property="ruc",type="string",example="12345678"),
     *                            @OA\Property(property="razon_social",type="string",example="Grupos y Asociados"),
     *                            @OA\Property(property="responsable",type="String",example="Responsable"),
     *                            @OA\Property(property="nombre_comercial",type="String",example="Nombre Comercial"),
     *                            @OA\Property(property="latitud",type="String",example="38° 50′ 84″ N"),
     *                            @OA\Property(property="longitud",type="String",example="10°O 30°O 50°O"),
     *                            @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                            @OA\Property(property="distrito_id",type="foreignId",example="1"),
     *                            @OA\Property(property="direccion",type="string",example="dirección example..."),
     *                            @OA\Property(property="logo",type="string",example=""),
     *                            @OA\Property(property="estado_registro",type="char",example="A")
     *                         )
     *                     )
     *                  )
     *              ),
     *              @OA\Property(property="size", type="number", example=1),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al llamar las empresas que pertenecen a la clínica"),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No hay contratos de clínica - empresa"),
     *          )
     *      )
     *  )
     */
    public function getEmpresas()
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            //return response()->json($usuario);
            $contratos = Contrato::with('empresa')
                ->where('clinica_id', $usuario->user_rol[0]->rol->clinica_id )
                ->where('estado_registro', 'A')
                ->get();

            if (!$contratos){
                return response()->json(["error" => "No hay contratos de clínica - empresa"], 401);
            }

            return response()->json(["data" => $contratos, "size" => count($contratos)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => "Error al llamar las empresas que pertenecen a la clínica" . $e], 400);
        }
    }
}
