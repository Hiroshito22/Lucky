<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\ContratoController;
use App\Models\UserRol;
use App\Http\Controllers\Controller;
use App\Models\Acceso;
use App\Models\AccesoRol;
use Illuminate\Support\Facades\DB;
use App\Models\Bregma;
use App\Models\BregmaPersonal;
use App\Models\Celular;
use App\Models\Correo;
use App\Models\Persona;
use App\Models\Rol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Hospital\ClinicaController;
use App\Http\Controllers\PersonaController;
use App\Models\CelularInstitucion;
use App\Models\Clinica;
use App\Models\Contrato;
use App\Models\CorreoInstitucion;

class BregmaController extends Controller
{
    private $BPersonal;
    private $Clinica;
    private $Persona;
    public function __construct(BregmaPersonalController $BPersonal, ClinicaController $Clinica, PersonaController $Persona)
    {
        $this->Persona = $Persona;
        $this->BPersonal = $BPersonal;
        $this->Clinica = $Clinica;
    }
    /**
     * Crear datos de bregma
     * @OA\Post (
     *     path="/api/bregma/create",
     *     summary="Crea datos de bregma con sesión iniciada",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Bregma"},
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                      @OA\Property(property="distrito_id", type="number"),
     *                      @OA\Property(property="numero_documento", type="string"),
     *                      @OA\Property(property="razon_social", type="string"),
     *                      @OA\Property(property="direccion", type="string"),
     *                      @OA\Property(property="latitud", type="string"),
     *                      @OA\Property(property="longitud", type="string"),
     *                      @OA\Property(property="celular", type="number"),
     *                      @OA\Property(property="correo", type="string"),
     *                 ),
     *                 example={
     *                     "distrito_id": 1,
     *                     "numero_documento": "54157485",
     *                     "razon_social": "MOE SIMPLER",
     *                     "direccion": "Av. Cantogrande 415",
     *                     "latitud": "19° 25′ 42″ N",
     *                     "longitud": "99° 7′ 39″ O",
     *                     "celular": 965014548,
     *                     "correo": "bot3@gmail.com"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Parameter(description="ID del distrito", @OA\Schema(type="number"), name="distrito_id", in="query", required= false, example=1),
     *      @OA\Parameter(description="Numero del documento", @OA\Schema(type="string"), name="numero_documento", in="query", required= true, example="54126485"),
     *      @OA\Parameter(description="Nombre de razon social", @OA\Schema(type="string"), name="razon_social", in="query", required= true, example="MARGE SIMPSON"),
     *      @OA\Parameter(description="Direccion de Bregma", @OA\Schema(type="string"), name="direccion", in="query", required= false, example="Av. Los pinos 451, block 2"),
     *      @OA\Parameter(description="Latitud del Bregma", @OA\Schema(type="string"), name="latitud", in="query", required= false, example="19° 25′ 42″ N"),
     *      @OA\Parameter(description="Longitud del Bregma", @OA\Schema(type="string"),name="longitud", in="query", required= false, example="99° 7′ 39″ O"),
     *      @OA\Parameter(description="Número de celular", @OA\Schema(type="number"), name="celular", in="query", required= false, example=954175845),
     *      @OA\Parameter(description="Correo electronico", @OA\Schema(type="string"),name="correo",in="query", required= false, example="bot3@gmail.com"),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Datos de Bregma creada"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un tipo de documento"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un numero de documento"),
     *          )
     *      ),
     *      @OA\Response(response=402, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un nombre de razon social"),
     *          )
     *      ),
     *      @OA\Response(response=403, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Otro registro a cuenta con el numero de documento"),
     *          )
     *      ),
     *      @OA\Response(response=404, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El numero de celular ya se encuentra registrado"),
     *          )
     *      ),
     *      @OA\Response(response=405, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El correo ya se encuentra registrado"),
     *          )
     *      ),
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $dni = User::where("username", $request->numero_documento)->where('estado_registro', 'A')->first();
            $reglas = [
                'numero_documento' => 'required',
                'razon_social' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if ($dni) return response()->json(["error" => "Otro registro ya cuenta con el numero de documento"], 403);
            $bregma = Bregma::updateOrcreate([
                "tipo_documento_id" => 2,
                "numero_documento" => $request->numero_documento == '' ? null : $request->numero_documento,
            ], [
                "distrito_id" => $request->distrito_id == '' ? null : $request->distrito_id,
                "razon_social" => $request->razon_social == '' ? null : $request->razon_social,
                "direccion" => $request->direccion == '' ? null : $request->direccion,
                "estado_pago" => $request->estado_pago == '' ? null : $request->estado_pago,
                "latitud" => $request->latitud == '' ? null : $request->latitud,
                "longitud" => $request->longitud == '' ? null : $request->longitud,
                "estado_registro" => 'A'
            ]);
            $persona = $this->Persona->store_institucion($request, $bregma->id, null, null);
            // return response()->json($persona);
            $usuario = User::updateOrCreate([
                "username" => $request->numero_documento,
                "persona_id" => $persona->id
            ], [
                "password" => $request->numero_documento,
                "estado_registro" => 'A'
            ]);
            $rol = Rol::firstOrCreate([
                "nombre" => "Administrador Bregma",
                "tipo_acceso" => 1,
                "bregma_id" => $bregma->id
            ], [
                "estado_registro" => "AD"
            ]);
            $usuario_rol = UserRol::updateOrCreate([
                "user_id" => $usuario->id,
                "rol_id" => $rol->id,
            ], [
                "tipo_rol" => 2,
                "estado_registro" => 'A'
            ]);
            $accesos = Acceso::where('tipo_acceso',1)->get();
            foreach ($accesos as $acceso) {
                $acceso_rol = AccesoRol::firstOrCreate(
                    [
                        "acceso_id" => $acceso["id"],
                        "rol_id" => $rol->id,
                    ],
                    []
                );
            }
            DB::commit();
            return response()->json(["resp" => "Datos de Bregma creada"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     * Actualiza datos de bregma
     * @OA\Put (
     *     path="/api/bregma/update/{id}",
     *     summary="Actualiza datos de bregma teniendo como parametro el id del bregma con sesión iniciada",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Bregma"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="distrito_id", type="number"),
     *                      @OA\Property(property="numero_documento", type="string"),
     *                      @OA\Property(property="razon_social", type="string"),
     *                      @OA\Property(property="direccion", type="string"),
     *                      @OA\Property(property="estado_pago", type="string"),
     *                      @OA\Property(property="latitud", type="string"),
     *                      @OA\Property(property="longitud", type="string"),
     *                      @OA\Property(property="celular", type="number"),
     *                      @OA\Property(property="correo", type="string"),
     *                 ),
     *                 example={
     *                     "distrito_id": 1,
     *                     "numero_documento": "54157485",
     *                     "razon_social": "MOE SIMPLER",
     *                     "direccion": "Av. Cantogrande 415",
     *                     "estado_pago": "0",
     *                     "latitud": "19° 25′ 42″ N",
     *                     "longitud": "99° 7′ 39″ O",
     *                     "celular": 935241845,
     *                     "correo": "bot3@gmail.com"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Parameter(description="ID del bregma", @OA\Schema(type="number"), name="id", in="path", required= true, example=2),
     *      @OA\Parameter(description="ID del distrito", @OA\Schema(type="number"), name="distrito_id", in="query", required= false, example=1),
     *      @OA\Parameter(description="Numero del documento", @OA\Schema(type="string"), name="numero_documento", in="query", required= false, example="54126485"),
     *      @OA\Parameter(description="Nombre de razon social", @OA\Schema(type="string"), name="razon_social", in="query", required= false, example="MARGE SIMPSON"),
     *      @OA\Parameter(description="Direccion de Bregma", @OA\Schema(type="string"), name="direccion", in="query", required= false, example="Av. Los pinos 451, block 2"),
     *      @OA\Parameter(description="Latitud del Bregma", @OA\Schema(type="string"), name="latitud", in="query", required= false, example="19° 25′ 42″ N"),
     *      @OA\Parameter(description="Longitud del Bregma",@OA\Schema(type="string"),name="longitud", in="query", required= false, example="99° 7′ 39″ O"),
     *      @OA\Parameter(description="Número de celular", @OA\Schema(type="number"), name="celular", in="query", required= false,example=954175845),
     *      @OA\Parameter(description="Correo electronico", @OA\Schema(type="string"), name="correo", in="query", required= false, example="bot3@gmail.com"),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos de Bregma actualizada"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos con este id"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un tipo de documento"),
     *          )
     *      ),
     *      @OA\Response(response=402, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un numero de documento"),
     *          )
     *      ),
     *      @OA\Response(response=403, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un nombre de razon social"),
     *          )
     *      ),
     *      @OA\Response(response=404, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Otro registro ya cuenta con el numero de documento"),
     *          )
     *      ),
     *      @OA\Response(response=405, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El numero de celular ya se encuentra registrado"),
     *          )
     *      ),
     *      @OA\Response(response=406, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El correo ya se encuentra registrado"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $bregma = Bregma::find($id);
            $user = User::with('user_rol', 'persona')->where('username', $bregma->numero_documento)->first();
            $persona = Persona::find($user->persona_id);
            if (!$bregma) return response()->json(["error" => "No existen datos con este id"], 400);
            $reglas = [
                'razon_social' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            $bregma->fill([
                "tipo_documento_id" => 2,
                "distrito_id" => $request->distrito_id,
                "user_rol_id" => $user->user_rol[0]->id,
                "numero_documento" => $request->numero_documento,
                "razon_social" => $request->razon_social,
                "direccion" => $request->direccion,
                "estado_pago" => $request->estado_pago,
                "latitud" => $request->latitud,
                "longitud" => $request->longitud,
            ])->save();
            $persona->fill([
                "numero_documento" => $bregma->numero_documento
            ])->save();
            CelularInstitucion::updateOrCreate([
                'persona_id' => $persona->id,
                'bregma_id' => $bregma->id
            ], [
                'celular' => $request->celular
            ])->save();
            CorreoInstitucion::updateOrCreate([
                'persona_id' => $persona->id,
                'bregma_id' => $bregma->id
            ], [
                'correo' => $request->correo
            ])->save();
            $user->fill([
                'username' => $persona->numero_documento,
                'password' => $persona->numero_documento
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Datos de Bregma actualizada"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Eliminar datos de bregma
     *  @OA\Delete (
     *      path="/api/bregma/delete/{id}",
     *      summary="Inhabilita el registro bregma teniendo como parametro el id del bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma"},
     *      @OA\Parameter(description="ID del Bregma",
     *          @OA\Schema(type="number"),name="id", in="path", required= true, example=2
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos de Bregma inhabilitadas")
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos con este id")
     *          )
     *      )
     *  )
     */

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $bregma = Bregma::find($id);
            // $clinicas = Clinica::where('bregma_id', $bregma->id)->get();
            $contrato = Contrato::where('bregma_id', $bregma->id)->get();
            
            $clinicas = Clinica::with(['contrato'])->where('id',$contrato[0]->clinica_id)->get();
            
            if (!$bregma) return response()->json(["error" => "No existen archivos con ese id"], 400);
            $usuario = User::where('username', $bregma->numero_documento)->first();
            $persona  = Persona::find($usuario->persona->id);
            $trabajadores = BregmaPersonal::where('bregma_id', $bregma->id)->get();
            foreach ($trabajadores as $personal) {
                $this->BPersonal->delete($personal->id);
            }
            foreach ($clinicas as $clinica) {
                $this->Clinica->destroy($clinica->id);
            }
            $bregma->fill([
                'estado_registro' => 'I'
            ])->save();
            $usuario->fill([
                'estado_registro' => 'I'
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Se elimino el bregma correctamente"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Activar datos de bregma
     *  @OA\Put (
     *      path="/api/bregma/activar/{id}",
     *      summary="Habilita el registro bregma teniendo como parametro el id del bregma",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma"},
     *      @OA\Parameter(description="ID del Bregma",
     *          @OA\Schema(type="number"),name="id", in="path", required= true, example=2
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Se activo el bregma correctamente")
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos con este id")
     *          )
     *      )
     *  )
     */


    public function activar($id)
    {
        DB::beginTransaction();
        try {
            $bregma = Bregma::find($id);
            // return response()->json($bregma);
            $contrato = Contrato::where('bregma_id', $bregma->id)->get();
            // return response()->json($contrato);
            // $clinicas = Clinica::where('bregma_id', $bregma->id)->get();
            $clinicas = Clinica::with(['contrato'])->where('id',$contrato[0]->clinica_id)->get();
            // return response()->json($clinicas[0]->id);
            if (!$bregma) return response()->json(["error" => "No existen datos con ese id"], 400);
            $usuario = User::where('username', $bregma->numero_documento)->first();
            $persona  = Persona::find($usuario->persona->id);
            $trabajadores = BregmaPersonal::where('bregma_id', $bregma->id)->get();
            foreach ($trabajadores as $personal) {
                $this->BPersonal->activar($personal->id);
            }
            foreach ($clinicas as $clinica) {
                $this->Clinica->activar($clinica->id);
            }
            // return response()->json($bregma);
            $bregma->fill([
                'estado_registro' => 'A'
            ])->save();
            
            $usuario->fill([
                'estado_registro' => 'A'
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Se activo el bregma correctamente"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     * Muestra todos los registros de Bregma
     * @OA\Get (
     *     path="/api/bregma/show",
     *     summary="Muestra datos de bregma teniendo como parametro el id del bregma con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma"},
     *     @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="74254566"),
     *                      @OA\Property(property="razon_social", type="string", example="BOT-COMPANY"),
     *                      @OA\Property(property="direccion", type="string", example="Av. Cantogrande 415"),
     *                      @OA\Property(property="estado_pago", type="string", example=0),
     *                      @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                      @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="tipo_documento",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="DNI"),
     *                              @OA\Property(property="codigo", type="string", example="PE"),
     *                              @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          )
     *                      ),
     *                      @OA\Property(type="array",property="distrito",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="distrito", type="string", example="MONTEVIDEO"),
     *                              @OA\Property(property="provincia_id", type="number", example=1),
     *                              @OA\Property(type="array",property="provincia",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="id", type="number", example=1),
     *                                      @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                                      @OA\Property(property="departamento_id", type="number", example=1),
     *                                      @OA\Property(type="array",property="departamento",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                                          )
     *                                      ),
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                      @OA\Property(type="array",property="celulares",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=4),
     *                              @OA\Property(property="celular", type="number", example=965241578),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                              @OA\Property(property="empresa_id", type="number", example=null),
     *                              @OA\Property(property="persona_id", type="number", example=10),
     *                              @OA\Property(property="bregma_id", type="number", example=8),
     *                              @OA\Property(type="array", property="persona",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="id", type="number", example=5),
     *                                      @OA\Property(property="foto", type="file", example=null),
     *                                      @OA\Property(property="numero_documento", type="string", example="48569512"),
     *                                      @OA\Property(property="nombres", type="string", example="Bernardo"),
     *                                      @OA\Property(property="apellido_paterno", type="string", example="Vaca"),
     *                                      @OA\Property(property="apellido_materno", type="string", example="zeta"),
     *                                      @OA\Property(property="fecha_nacimiento", type="string", example="2002-04-27"),
     *                                      @OA\Property(property="celular", type="string", example="954784545"),
     *                                      @OA\Property(property="telefono", type="string", example="2879410"),
     *                                      @OA\Property(property="email", type="string", example="email_prueba@gmail.com"),
     *                                      @OA\Property(property="direccion", type="string", example="Av. las fresias 328"),
     *                                      @OA\Property(property="telefono_emergencia", type="string", example=null),
     *                                      @OA\Property(property="contacto_emergencia", type="string", example=null),
     *                                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                                      @OA\Property(property="distrito_id", type="number", example=1),
     *                                      @OA\Property(property="distrito_domicilio_id", type="number", example=null),
     *                                      @OA\Property(property="estado_civil_id", type="number", example=null),
     *                                      @OA\Property(property="religion_id", type="number", example=null),
     *                                      @OA\Property(property="sexo_id", type="number", example=null),
     *                                      @OA\Property(property="grado_instruccion_id", type="number", example=null),
     *                                      @OA\Property(type="array", property="tipo_documento",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=6),
     *                                              @OA\Property(property="nombre", type="string", example="DNI"),
     *                                              @OA\Property(property="codigo", type="number", example=1),
     *                                              @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                                          )
     *                                      ),
     *                                      @OA\Property(type="array",property="distrito",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="distrito", type="string", example="MONTEVIDEO"),
     *                                              @OA\Property(property="provincia_id", type="number", example=1),
     *                                              @OA\Property(type="array",property="provincia",
     *                                                  @OA\Items(type="object",
     *                                                      @OA\Property(property="id", type="number", example=1),
     *                                                      @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                                                      @OA\Property(property="departamento_id", type="number", example=1),
     *                                                      @OA\Property(type="array",property="departamento",
     *                                                          @OA\Items(type="object",
     *                                                              @OA\Property(property="id", type="number", example=1),
     *                                                              @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                                                          )
     *                                                      ),
     *                                                  )
     *                                              ),
     *                                          )
     *                                      ),
     *                                      @OA\Property(type="array", property="distrito_domicilio",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="descripcion", type="string", example=null),
     *                                          )
     *                                      ),
     *                                      @OA\Property(type="array", property="estado_civil",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="nombre", type="string", example=null),
     *                                          )
     *                                      ),
     *                                      @OA\Property(type="array", property="religion",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="descripcion", type="string", example="Catolica"),
     *                                              @OA\Property(property="estado_registro", type="string", example=null),
     *                                          )
     *                                      ),
     *                                      @OA\Property(type="array", property="sexo",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="nombre", type="string", example=null),
     *                                          )
     *                                      ),
     *                                      @OA\Property(type="array", property="grado_instruccion",
     *                                          @OA\Items(type="object",
     *                                              @OA\Property(property="id", type="number", example=1),
     *                                              @OA\Property(property="nombre", type="string", example=null),
     *                                          )
     *                                      ),
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                      @OA\Property(type="array",property="correos",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=4),
     *                              @OA\Property(property="correo", type="number", example="bot4@gmail.com"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                              @OA\Property(property="empresa_id", type="number", example=null),
     *                              @OA\Property(property="persona_id", type="number", example=10),
     *                              @OA\Property(property="clinica_id", type="number", example=null),
     *                              @OA\Property(property="bregma_id", type="number", example=8),
     *                          )
     *                      ),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos"),
     *          )
     *      )
     * )
     */
    public function show()
    {
        try {
            $bregma = Bregma::with(
                'tipo_documento',
                'distrito.provincia.departamento',
                'celulares',
                'correos',
                'detracciones',
                'entidad_pagos.entidad_bancaria'
            )->where('numero_documento', auth()->user()->username)->first();
            return response()->json($bregma);
            if (!$bregma) {
                return response()->json("No existen datos");
            } else {
                return response()->json(["data" => $bregma]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Muestra todos los contratos de Bregma
     * @OA\Get (
     *     path="/api/bregma/contratos/get",
     *     summary="Muestra todos los contratos de Bregma",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma"},
     *     @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_cliente_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
     *                      @OA\Property(property="fecha_inicio", type="string", example="2002-10-01"),
     *                      @OA\Property(property="fecha_vencimiento", type="string", example="2002-10-01"),
     *                      @OA\Property(property="estado_contrato", type="number", example=0),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object",property="clinica",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="tipo_documento_id", type="number", example=2),
     *                          @OA\Property(property="distrito_id", type="number", example=1),
     *                          @OA\Property(property="razon_social", type="string", example="Company"),
     *                          @OA\Property(property="numero_documento", type="string", example="04521541"),
     *                          @OA\Property(property="responsable", type="string", example="Juan Ivan"),
     *                          @OA\Property(property="nombre_comercial", type="string", example="Fanta"),
     *                          @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                          @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                          @OA\Property(property="logo", type="file", example="foto.jpg"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                          @OA\Property(property="hospital_id", type="string", example=1),
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
            $contratos = Contrato::with('clinica.tipo_documento', 'clinica.distrito.provincia.departamento')
                ->where('clinica_id', '!=', null, 'or', 'empresa_id', '!=', null)
                ->where('bregma_id', '=', $usuario->user_rol[0]->rol->bregma_id)->get();
            if (count($contratos) == 0) return response()->json(["error" => "No hay contratos de bregma"]);
            return response()->json(["data" => $contratos, "size" => count($contratos)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Muestra todos los contratos con la clínica que tiene Bregma,
     * @OA\Get (
     *     path="/api/bregma/contratos/clinica/get",
     *     summary="Muestra todos los contratos con la clínica que tiene Bregma",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma"},
     *     @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_cliente_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=""),
     *                      @OA\Property(property="bregma_paquete_id", type="number", example=1),
     *                      @OA\Property(property="fecha_inicio", type="string", example="2002-10-01"),
     *                      @OA\Property(property="fecha_vencimiento", type="string", example="2002-10-01"),
     *                      @OA\Property(property="estado_contrato", type="number", example=0),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object",property="clinica",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="tipo_documento_id", type="number", example=2),
     *                          @OA\Property(property="distrito_id", type="number", example=1),
     *                          @OA\Property(property="razon_social", type="string", example="Company"),
     *                          @OA\Property(property="numero_documento", type="string", example="04521541"),
     *                          @OA\Property(property="responsable", type="string", example="Pepito"),
     *                          @OA\Property(property="nombre_comercial", type="string", example="Fanta"),
     *                          @OA\Property(property="latitud", type="string", example="19° 25′ 42″ N"),
     *                          @OA\Property(property="longitud", type="string", example="99° 7′ 39″ O"),
     *                          @OA\Property(property="direccion", type="string", example="Av. Cantogrande 415"),
     *                          @OA\Property(property="logo", type="file", example="foto.jpg"),
     *                          @OA\Property(property="estado_pago", type="string", example="A"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                  )
     *              ),
     *            @OA\Property(property="size", type="number", example=1),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al llamar los contratos de Bregma que tiene con clínica"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No hay contratos de bregma - clínica"),
     *          )
     *      )
     *  )
     */
    public function getClinicas()
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            //return response()->json($usuario);
            $contratos = Contrato::with('clinica')
                ->where('bregma_id', $usuario->user_rol[0]->rol->bregma_id )
                ->where('estado_registro', 'A')
                ->get();

            if (count($contratos) == 0) return response()->json(["error" => "No hay contratos de bregma - clínica"], 401);

            return response()->json(["data" => $contratos, "size" => count($contratos)], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => "Error al llamar los contratos de Bregma que tiene con clínica" . $e], 400);
        }
    }
}
