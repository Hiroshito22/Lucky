<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonaController;
use App\Models\BregmaPersonal;
use App\Models\Celular;
use App\Models\ClinicaPersonal;
use App\Models\Correo;
use App\Models\EmpresaPersonal;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\UserRol;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmpresaReclutamientoController extends Controller
{
    private $Persona;
    public function __construct(PersonaController $Persona)
    {
        $this->Persona = $Persona;
    }
    /**
     *  Crear personal de empresa
     *  @OA\Post (
     *      path="/api/empresa/personal/reclutamiento/create",
     *      summary="Crea un personal de Empresa",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="tipo_documento_id",in="query",required= true,example=1),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="numero_documento",in="query",required= false,example="65656565"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="nombres",in="query",required= false,example="Juan"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required= false,example="Perez"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required= false,example="Garcia"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="fecha_nacimiento",in="query",required= false,example="1990-05-15"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="celular",in="query",required= false,example="987654321"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="telefono",in="query",required= false,example="013245678"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="correo",in="query",required= false,example="juan@example.com"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false,example="Calle Los Pinos 123"),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="telefono_emergencia",in="query",required= false,example="012345678",),
     *      @OA\Parameter(
     *          @OA\Schema(type="string"),name="contacto_emergencia",in="query",required= false,example="Maria Perez"),
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="distrito_id",in="query",required= false,example=1),
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="distrito_domicilio_id",in="query",required= false,example=2),
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="estado_civil_id",in="query",required= false, example=1),
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="religion_id",in="query",required= false, example=3),
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="sexo_id",in="query",required= false, example=1),
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="grado_instruccion_id",in="query",required= false, example=4),
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="rol_id",in="query",required= false,example=2),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="tipo_documento_id",type="number"),
     *                      @OA\Property(property="numero_documento",type="string"),
     *                      @OA\Property(property="nombres",type="string"),
     *                      @OA\Property(property="apellido_paterno",type="string"),
     *                      @OA\Property(property="apellido_materno",type="string"),
     *                      @OA\Property(property="fecha_nacimiento",type="string"),
     *                      @OA\Property(property="celular",type="string"),
     *                      @OA\Property(property="telefono",type="string"),
     *                      @OA\Property(property="correo",type="string"),
     *                      @OA\Property(property="direccion",type="string"),
     *                      @OA\Property(property="telefono_emergencia",type="string"),
     *                      @OA\Property(property="contacto_emergencia",type="string"),
     *                      @OA\Property(property="rol_id",type="foreignId"),
     *                      @OA\Property(property="distrito_id",type="foreignId"),
     *                      @OA\Property(property="distrito_domicilio_id",type="foreignId"),
     *                      @OA\Property(property="estado_civil_id",type="foreignId"),
     *                      @OA\Property(property="religion_id",type="foreignId"),
     *                      @OA\Property(property="sexo_id",type="foreignId"),
     *                      @OA\Property(property="grado_instruccion_id",type="foreignId")
     *                  ),
     *                  example={
     *                          "tipo_documento_id": 1,
     *                          "numero_documento": "65656565",
     *                          "nombres": "Juan",
     *                          "apellido_paterno": "Perez",
     *                          "apellido_materno": "Garcia",
     *                          "fecha_nacimiento": "1990-05-15",
     *                          "celular": "987654321",
     *                          "telefono": "013245678",
     *                          "correo": "juan@example.com",
     *                          "direccion": "Calle Los Pinos 123",
     *                          "telefono_emergencia": "012345678",
     *                          "contacto_emergencia": "Maria Perez",
     *                          "distrito_id": 1,
     *                          "distrito_domicilio_id": 2,
     *                          "estado_civil_id": 1,
     *                          "religion_id": 3,
     *                          "sexo_id": 1,
     *                          "grado_instruccion_id": 4,
     *                          "rol_id": 2,
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Personal creado correctamente")
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No ingreso datos en al campo :attribute"),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ya existe otro registro con el numero de documento"),
     *          )
     *      ),
     *      @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No existe rol con el id ingresado"),
     *          )
     *      )
     *  )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $persona = Persona::where('numero_documento', $request->numero_documento)->first();
            if ($persona) {
                $existe_personal_empresa = EmpresaPersonal::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
                $existe_personal_bregma = BregmaPersonal::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
                $existe_personal_clinica = ClinicaPersonal::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
                if ($existe_personal_empresa || $existe_personal_bregma || $existe_personal_clinica) return response()->json(["error" => "Ya existe otro registro con el numero de documento"], 500);
            }
            $rol = Rol::find($request->rol_id);
            $acceso_rol = Rol::where('empresa_id', $datos->user_rol[0]->rol->empresa_id)->find($request->rol_id);
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required',
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            // if (!$rol) return response()->json(["error" => "No existe rol con el id ingresado"], 501);
            // if (!$acceso_rol) return response()->json(["error" => "No tiene acceso al rol"], 502);
            $persona = $this->Persona->store($request);
            $usuario = User::updateOrCreate([
                'persona_id' => $persona->id,
                'username' => $persona->numero_documento,
            ], [
                'password' => $persona->numero_documento,
                'estado_registro' => 'A'
            ]);
            $user_rol = UserRol::updateOrCreate([
                'user_id' => $usuario->id,
            ], [
                'rol_id' => $request->rol_id,
                'estado_registro' => 'A'
            ]);
            $empresa_personal = EmpresaPersonal::updateOrCreate([
                'empresa_id' => $datos->user_rol[0]->rol->empresa_id,
                'user_rol_id' => $user_rol->id,
                'persona_id' => $persona->id
            ], [
                'estado_reclutamiento' => 1,
                'rol_id' => $request->rol_id,
                'estado_registro' => 'A',
            ]);
            DB::commit();
            return response()->json(["resp" => "Personal creado correctamente"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Actualiza un registro del personal de la Empresa segun el id de la ruta
     *  @OA\Put (
     *      path="/api/empresa/personal/reclutamiento/update/{id}",
     *      summary="Actualiza un registro del personal de la Empresa segun el id de la ruta",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Parameter(description="ID del personal Empresa",
     *          @OA\Schema(type="number"), name="id", in="path", required= false, example=2),
     *      @OA\Parameter(description="Id del tipo de documento",
     *          @OA\Schema(type="number"),name="tipo_documento_id", in="query", required= false, example=1),
     *      @OA\Parameter(description="Numero del documento",
     *          @OA\Schema(type="string"), name="numero_documento", in="query", required= false, example="07485459"),
     *      @OA\Parameter(description="Nombres",
     *          @OA\Schema(type="string"),name="nombres",in="query",required= false,example="Frank"),
     *      @OA\Parameter(description="Apellido paterno",
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required= false,example="Escovedo"),
     *      @OA\Parameter(description="Apellido materno",
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required= false,example="SIMPSON"),
     *      @OA\Parameter(description="Cargo del personal",
     *          @OA\Schema(type="string"),name="cargo",in="query",required= false,example="personal"),
     *      @OA\Parameter(description="Fecha de nacimiento",
     *          @OA\Schema(type="string"),name="fecha_nacimiento",in="query",required= false,example="2002-02-06"),
     *      @OA\Parameter(description="Hobbies del personal",
     *          @OA\Schema(type="string"),name="hobbies",in="query",required= false,example="futbol"),
     *      @OA\Parameter(description="Número de celular",
     *          @OA\Schema(type="string"),name="celular",in="query",required= false),
     *      @OA\Parameter(description="Número de telefono",
     *          @OA\Schema(type="string"),name="telefono",in="query",required= false),
     *      @OA\Parameter(description="Correo electronico",
     *          @OA\Schema(type="string"),name="correo",in="query",required= false),
     *      @OA\Parameter(description="Direccion",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false),
     *      @OA\Parameter(description="Número de telefono de emergencia",
     *          @OA\Schema(type="string"),name="telefono_emergencia",in="query",required= false),
     *      @OA\Parameter(description="Número de celular o telefono de contacto de emergencia",
     *          @OA\Schema(type="string"),name="contacto_emergencia",in="query",required= false),
     *      @OA\Parameter(description="ID del distrito",
     *          @OA\Schema(type="number"), name="distrito_id", in="query", required= false),
     *      @OA\Parameter(description="ID del distrito donde esta el domicilio",
     *          @OA\Schema(type="number"), name="distrito_domicilio_id", in="query",required= false),
     *      @OA\Parameter(description="ID de estado civil",
     *          @OA\Schema(type="number"), name="estado_civil_id", in="query", required= false),
     *      @OA\Parameter( description="ID de la religion",
     *          @OA\Schema(type="number"), name="religion_id", in="query", required= false),
     *      @OA\Parameter(description="ID del sexo o genero",
     *          @OA\Schema(type="number"), name="sexo_id", in="query", required= false),
     *      @OA\Parameter( description="ID del grado de instruccion",
     *          @OA\Schema(type="number"), name="grado_instruccion_id", in="query", required= false),
     *      @OA\Parameter(description="ID del Rol",
     *          @OA\Schema(type="number"), name="rol_id", in="query", required= false, example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="tipo_documento_id", type="number"),
     *                      @OA\Property(property="numero_documento", type="string"),
     *                      @OA\Property(property="nombres", type="string"),
     *                      @OA\Property(property="apellido_paterno", type="string"),
     *                      @OA\Property(property="apellido_materno", type="string"),
     *                      @OA\Property(property="cargo", type="string"),
     *                      @OA\Property(property="fecha_nacimiento", type="string"),
     *                      @OA\Property(property="hobbies", type="string"),
     *                      @OA\Property(property="celular", type="string"),
     *                      @OA\Property(property="telefono", type="string"),
     *                      @OA\Property(property="correo", type="string"),
     *                      @OA\Property(property="direccion", type="string"),
     *                      @OA\Property(property="telefono_emergencia", type="string"),
     *                      @OA\Property(property="contacto_emergencia", type="string"),
     *                      @OA\Property(property="distrito_id", type="number"),
     *                      @OA\Property(property="distrito_domicilio_id", type="number"),
     *                      @OA\Property(property="estado_civil_id", type="number"),
     *                      @OA\Property(property="religion_id", type="number"),
     *                      @OA\Property(property="sexo_id", type="number"),
     *                      @OA\Property(property="grado_instruccion_id", type="number"),
     *                      @OA\Property(property="rol_id", type="number"),
     *                 ),
     *                 example={
     *                     "tipo_documento_id":1,
     *                     "numero_documento": "04512486",
     *                     "nombres": "Bartolomeo",
     *                     "apellido_paterno": "Gutierrez",
     *                     "apellido_materno": "Palomino",
     *                     "fecha_nacimiento": "2002-04-27",
     *                     "celular": "954784545",
     *                     "telefono": null,
     *                     "correo": null,
     *                     "direccion": null,
     *                     "telefono_emergencia":null,
     *                     "contacto_emergencia":null,
     *                     "distrito_id":null,
     *                     "distrito_domicilio_id":null,
     *                     "estado_civil_id":null,
     *                     "religion_id":null,
     *                     "sexo_id":null,
     *                     "grado_instruccion_id":null,
     *                     "rol_id":1,
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Registro actualizado correctamente")
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso datos en al campo :attribute"),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen registros con este id"),
     *          )
     *      ),
     *      @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Ya existe otro registro con el numero de documento"),
     *          )
     *      ),
     *      @OA\Response(response=502,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe rol con el id ingresado"),
     *          )
     *      ),
     *      @OA\Response(response=503,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No tiene acceso al rol"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('user_rol.rol')->find(auth()->user()->id);
            $empresa_personal = EmpresaPersonal::with('persona')->find($id);
            if (!$empresa_personal) return response()->json(["resp" => "No existen registros con este id"], 500);
            $persona = Persona::find($empresa_personal->persona_id);
            $usuario = User::with('user_rol')->where('username', $persona->numero_documento)->first();
            $rol = Rol::find($request->rol_id);
            $acceso_rol = Rol::where('empresa_id', $datos->user_rol[0]->rol->empresa_id)->find($request->rol_id);
            //return response()->json($usuario);
            $dni = Persona::where("numero_documento", $request->numero_documento)->where("id", '!=', $persona->id)->first();
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required',
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'rol_id' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if ($dni) return response()->json(["error" => "Otro registro ya cuenta con el numero de documento"], 501);
            if (!$rol) return response()->json(["error" => "No existe rol con ese id"], 502);
            if (!$acceso_rol) return response()->json(["error" => "No tiene acceso al rol"], 503);

            $this->Persona->update($request, $empresa_personal->persona_id);
            $usuario = User::updateOrCreate(
                [
                    'persona_id' => $persona->id,
                ],
                [
                    'username' => $request->numero_documento,
                    "password" => $request->numero_documento,
                    'estado_registro' => 'A'
                ]
            );
            $user_rol = UserRol::updateOrCreate(
                [
                    'user_id' => $usuario->id,
                ],
                [
                    'rol_id' => $request->rol_id,
                    'estado_registro' => 'A'
                ]
            );
            $empresa_personal = EmpresaPersonal::updateOrCreate([
                'persona_id' => $persona->id
            ], [
                'rol_id' => $request->rol_id,
                'empresa_id' => $rol->empresa_id,
                'user_rol_id' => $user_rol->id,
            ]);
            DB::commit();
            return response()->json(["resp" => "Datos del personal Empresa actualizados"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Muestra todos los registros de Empresa
     *  @OA\Get (
     *      path="/api/empresa/personal/reclutamiento/get",
     *      summary="Muestra todo el personal en estado de reclutamiento de la empresa que esta con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=3),
     *                      @OA\Property(property="rol_id", type="number", example=6),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
     *                      @OA\Property(property="user_rol_id", type="number", example=3),
     *                      @OA\Property(property="persona_id", type="number", example=5),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object", property="user_rol",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="user_id", type="number", example=3),
     *                          @OA\Property(property="rol_id", type="number", example=6),
     *                          @OA\Property(property="tipo_rol", type="number", example=1),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                          @OA\Property(type="object", property="user",
     *                              @OA\Property(property="id", type="number", example=3),
     *                              @OA\Property(property="persona_id",type="number", example=5),
     *                              @OA\Property(property="username",type="string", example="48569512" )
     *                          ),
     *                      ),
     *                      @OA\Property(type="object", property="rol",
     *                          @OA\Property(property="id", type="number", example=6),
     *                          @OA\Property(property="nombre", type="string", example="Administrador Bregma"),
     *                          @OA\Property(property="bregma_id", type="number", example=null),
     *                          @OA\Property(property="empresa_id", type="number", example=1),
     *                          @OA\Property(property="clinica_id", type="number", example=null),
     *                          @OA\Property(property="tipo_acceso", type="number", example=2),
     *                          @OA\Property(property="estado_registro", type="string", example="AD"),
     *                      ),
     *                      @OA\Property(type="object", property="persona",
     *                          @OA\Property(property="id", type="number", example=5),
     *                          @OA\Property(property="foto", type="file", example=null),
     *                          @OA\Property(property="numero_documento", type="string", example="48569512"),
     *                          @OA\Property(property="nombres", type="string", example="Bernardo"),
     *                          @OA\Property(property="apellido_paterno", type="string", example="Vaca"),
     *                          @OA\Property(property="apellido_materno", type="string", example="zeta"),
     *                          @OA\Property(property="cargo", type="string", example="personal"),
     *                          @OA\Property(property="fecha_nacimiento", type="string", example="2002-04-27"),
     *                          @OA\Property(property="hobbies", type="string", example="futbol"),
     *                          @OA\Property(property="celular", type="string", example="954784545"),
     *                          @OA\Property(property="telefono", type="string", example="2879410"),
     *                          @OA\Property(property="correo", type="string", example="email_prueba@gmail.com"),
     *                          @OA\Property(property="direccion", type="string", example="Av. las fresias 328"),
     *                          @OA\Property(property="telefono_emergencia", type="string", example="2648451"),
     *                          @OA\Property(property="contacto_emergencia", type="string", example="954241548"),
     *                          @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                          @OA\Property(property="distrito_id", type="number", example=1),
     *                          @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *                          @OA\Property(property="estado_civil_id", type="number", example=1),
     *                          @OA\Property(property="religion_id", type="number", example=1),
     *                          @OA\Property(property="sexo_id", type="number", example=1),
     *                          @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *                          @OA\Property(type="object", property="tipo_documento",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="DNI"),
     *                              @OA\Property(property="codigo", type="number", example=1),
     *                              @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          ),
     *                          @OA\Property(type="object",property="distrito",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="distrito", type="string", example="MONTEVIDEO"),
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
     *                          @OA\Property(type="object", property="distrito_domicilio",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="descripcion", type="string", example="No hay tabla distrito_domicilio"),
     *                          ),
     *                          @OA\Property(type="object", property="estado_civil",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="Soltero(a)"),
     *                          ),
     *                          @OA\Property(type="object", property="religion",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="descripcion", type="string", example="Catolica"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          ),
     *                          @OA\Property(type="object", property="sexo",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="Masculino"),
     *                          ),
     *                          @OA\Property(type="object", property="grado_instruccion",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="Primaria"),
     *                          ),
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(property="size", type="number", example=1),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe personal en esta Empresa"),
     *          )
     *      )
     *  )
     */
    public function get()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $empresa_id = $usuario->user_rol[0]->rol->empresa_id;
            $empresa_personal = EmpresaPersonal::with(
                'user_rol.user',
                'rol',
                'persona.tipo_documento',
                'persona.distrito.provincia.departamento',
                'persona.distrito_domicilio',
                'persona.estado_civil',
                'persona.religion',
                'persona.sexo',
                'persona.grado_instruccion'
            )->where('empresa_id', $empresa_id)
            ->where('estado_reclutamiento',0)
            ->where('estado_registro','A')->get();
            if (count($empresa_personal) == 0) return response()->json(["resp" => "No existe personal en reclutamiento en esta Empresa"]);
            return response()->json(['data' => $empresa_personal, 'size' => count($empresa_personal)]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
}
