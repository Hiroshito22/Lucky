<?php

namespace App\Http\Controllers\Bregma;

use App\Models\Bregma;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonaController;
use App\Models\BregmaArea;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BregmaPersonalController extends Controller
{
    private $Persona;
    public function __construct(PersonaController $Persona)
    {
        $this->Persona = $Persona;
    }
    /**
     *  Crear un nuevo personal para bregma
     *  @OA\Post (
     *      path="/api/bregma/personal/create",
     *      summary="Crea personal de bregma",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Personal"},
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
     *                      @OA\Property(property="usuario", type="number"),
     *                  ),
     *                  example={
     *                      "tipo_documento_id":1,
     *                      "numero_documento": "04512486",
     *                      "nombres": "Bartolomeo",
     *                      "apellido_paterno": "Gutierrez",
     *                      "apellido_materno": "Palomino",
     *                      "cargo": "personal",
     *                      "fecha_nacimiento": "2002-04-27",
     *                      "hobbies": "futbol",
     *                      "celular": "954784545",
     *                      "telefono": null,
     *                      "correo": "juan@example.com",
     *                      "direccion": null,
     *                      "telefono_emergencia":null,
     *                      "contacto_emergencia":null,
     *                      "distrito_id":null,
     *                      "distrito_domicilio_id":null,
     *                      "estado_civil_id":null,
     *                      "religion_id":null,
     *                      "sexo_id":null,
     *                      "grado_instruccion_id":null,
     *                      "rol_id":1,
     *                      "usuario":1
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Parameter(description="Id del tipo de documento",
     *          @OA\Schema(type="number"),name="tipo_documento_id",in="query",required= false,example=1),
     *      @OA\Parameter(description="Numero del documento",
     *          @OA\Schema(type="string"),name="numero_documento",in="query",required= false,example="07485459"),
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
     *          @OA\Schema(type="string"),name="celular",in="query",required= false,example="965214545"),
     *      @OA\Parameter(description="Número de telefono",
     *          @OA\Schema(type="string"),name="telefono",in="query",required= false,example="2415410"),
     *      @OA\Parameter(description="Correo electronico",
     *          @OA\Schema(type="string"),name="correo",in="query",required= false),
     *      @OA\Parameter(description="Dirección",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false),
     *      @OA\Parameter(description="Número de telefono de emergencia",
     *          @OA\Schema(type="string"),name="telefono_emergencia",in="query",required= false),
     *      @OA\Parameter(description="Número de celular o telefono de contacto de emergencia",
     *          @OA\Schema(type="string"),name="contacto_emergencia",in="query",required= false),
     *      @OA\Parameter(description="ID del distrito",
     *          @OA\Schema(type="number"),name="distrito_id",in="query",required= false),
     *      @OA\Parameter(description="ID del distrito donde esta el domicilio",
     *          @OA\Schema(type="number"),name="distrito_domicilio_id",in="query",required= false),
     *      @OA\Parameter(description="ID de estado civil",
     *          @OA\Schema(type="number"),name="estado_civil_id",in="query",required= false),
     *      @OA\Parameter(description="ID de la religión",
     *          @OA\Schema(type="number"),name="religion_id",in="query",required= false),
     *      @OA\Parameter(description="ID del sexo o genero",
     *          @OA\Schema(type="number"),name="sexo_id",in="query",required= false),
     *      @OA\Parameter(description="ID del grado de instrucción",
     *          @OA\Schema(type="number"),name="grado_instruccion_id",in="query",required= false),
     *      @OA\Parameter(description="ID del Rol",
     *          @OA\Schema(type="number"),name="rol_id",in="query",required= false,example=1),
     *      @OA\Parameter(description="¿Sera usuario? 0=No 1=Si",
     *          @OA\Schema(type="number"),name="usuario",in="query",required= false,example=1),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos del Personal Bregma creada"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso datos en al campo :attribute"),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Ya existe otro registro con el numero de documento"),
     *          )
     *      ),
     *      @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe rol con el id ingresado"),
     *          )
     *      ),
     *      @OA\Response(response=502,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No tiene acceso al rol"),
     *          )
     *      ),
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
            if (!$rol) return response()->json(["error" => "No existe rol con el id ingresado"], 501);
            $acceso_rol = Rol::where('bregma_id', $datos->user_rol[0]->rol->bregma_id)->find($rol->id);
            // return response()->json($request);
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required',
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'distrito_id' => 'required',
                'rol_id' => 'required',
                'usuario' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if (!$acceso_rol) return response()->json(["error" => "No tiene acceso al rol"], 502);
            $persona = $this->Persona->store($request);
            if ($request->usuario == 0) {
                $bregma_personal = BregmaPersonal::updateOrCreate([
                    'bregma_id' => $datos->user_rol[0]->rol->bregma_id,
                    'persona_id' => $persona->id
                ], [
                    'rol_id' => $request->rol_id,
                    'estado_registro' => 'A'
                ]);
            } else {
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
                $bregma_personal = BregmaPersonal::updateOrCreate([
                    'bregma_id' => $datos->user_rol[0]->rol->bregma_id,
                    'user_rol_id' => $user_rol->id,
                    'persona_id' => $persona->id
                ], [
                    'rol_id' => $request->rol_id,
                    'estado_registro' => 'A'
                ]);
            }
            DB::commit();
            return response()->json(["resp" => "Bregma personal creada"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Actualizar personal de bregma mediante el id del personal
     *  @OA\Put (
     *      path="/api/bregma/personal/update/{id}",
     *      summary="Actualiza datos de personal de bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Personal"},
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
     *                      @OA\Property(property="usuario", type="number"),
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
     *                     "usuario":1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Parameter(description="ID del personal Bregma a actualizar",
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
     *      @OA\Parameter(description="¿Sera usuario? 0=No 1=Si",
     *          @OA\Schema(type="number"), name="usuario", in="query", required= false, example=1),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos del Personal Bregma actualizadas"),
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
     *  )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('user_rol.rol')->find(auth()->user()->id);
            $bregma_personal = BregmaPersonal::where('estado_registro', 'A')->find($id);
            if (!$bregma_personal) return response()->json(["resp" => "No existen registros con este id"], 500);
            $persona = Persona::find($bregma_personal->persona_id);
            $usuario = User::with('user_rol')->where('username', $persona->numero_documento)->first();
            $rol = Rol::find($request->rol_id);
            $acceso_rol = Rol::where('bregma_id', $datos->user_rol[0]->rol->bregma_id)->find($request->rol_id);
            // return response()->json($rol);
            $celular = Celular::where('persona_id', $persona->id)->first();
            $correo = Correo::where('persona_id', $persona->id)->first();
            $dni = Persona::where("numero_documento", $request->numero_documento)->where("id", '!=', $persona->id)->first();
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required',
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'distrito_id' => 'required',
                'rol_id' => 'required',
                'usuario' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if ($dni) return response()->json(["error" => "Otro registro ya cuenta con el numero de documento"], 501);
            if (!$rol) return response()->json(["error" => "No existe rol con ese id"], 502);
            if (!$acceso_rol) return response()->json(["error" => "No tiene acceso al rol"], 503);

            $persona = $this->Persona->update($request, $persona->id);
            if ($request->usuario == 0) {
                if ($usuario) {
                    $user_rol = UserRol::find($usuario->user_rol[0]->id);
                    $user_rol->fill([
                        'estado_registro' => 'I'
                    ])->save();
                    $usuario->fill([
                        'username' => $request->numero_documento,
                        'password' => $request->numero_documento,
                        'estado_registro' => 'I'
                    ])->save();

                    $bregma_personal->fill([
                        'rol_id' => $request->rol_id,
                        'bregma_id' => $rol->bregma_id,
                        'persona_id' => $persona->id,
                        'user_rol_id' => null
                    ])->save();
                }
                $bregma_personal->fill([
                    'rol_id' => $request->rol_id,
                    'bregma_id' => $rol->bregma_id,
                    'persona_id' => $persona->id,
                    'user_rol_id' => null
                ])->save();
            } else {
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
                $bregma_personal = BregmaPersonal::updateOrCreate([
                    'persona_id' => $persona->id
                ], [
                    'rol_id' => $request->rol_id,
                    'bregma_id' => $rol->bregma_id,
                    'user_rol_id' => $user_rol->id,
                ]);
            }
            DB::commit();
            return response()->json(["resp" => "Datos del personal Bregma actualizados"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Deshabilita personal de bregma teniendo como parametro el id del personal
     *  @OA\Delete (
     *      path="/api/bregma/personal/delete/{id}",
     *      summary="Deshabilita el registro del personal bregma teniendo como parametro el id del personal bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Personal"},
     *      @OA\Parameter(description="ID del registro del personal a deshabilitar",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos del personal Bregma inhabilitadas"),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos con este id"),
     *          )
     *      )
     *  )
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $bregma_personal = BregmaPersonal::find($id);
            $persona = Persona::find($bregma_personal->persona_id);
            $celular = Celular::where('persona_id', $persona->id)->first();
            $correo = Correo::where('persona_id', $persona->id)->first();
            $user_rol = UserRol::with('user')->find($bregma_personal->user_rol_id);
            if (!$bregma_personal) return response()->json(["error" => "No existen registros con este ID"], 500);
            $bregma_personal->fill([
                'estado_registro' => 'I'
            ])->save();
            $celular->fill([
                'estado_registro' => 'I'
            ])->save();
            $correo->fill([
                'estado_registro' => 'I'
            ])->save();
            if ($user_rol) {
                $usuario = User::find($user_rol->user->id);
                $user_rol->fill([
                    'estado_registro' => 'I'
                ])->save();
                $usuario->fill([
                    'estado_registro' => 'I'
                ])->save();
            }
            DB::commit();
            return response()->json(["resp" => "Datos del personal Bregma inhabilitados"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Activar personal de bregma teniendo como parametro el id del personal
     *  @OA\Put (
     *      path="/api/bregma/personal/activar/{id}",
     *      summary="Habilita el registro del personal bregma teniendo como parametro el id del personal bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Personal"},
     *      @OA\Parameter(description="ID del registro del personal Bregma a habilitar",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos del personal Bregma habilitadas"),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos con este id"),
     *          )
     *      )
     *  )
     */
    public function activar($id)
    {
        DB::beginTransaction();
        try {
            $bregma_personal = BregmaPersonal::find($id);
            if (!$bregma_personal) return response()->json(["error" => "No existen registros con este ID"]);
            $persona = Persona::find($bregma_personal->persona_id);
            $celular = Celular::where('persona_id', $persona->id)->first();
            $correo = Correo::where('persona_id', $persona->id)->first();
            $user_rol = UserRol::with('user')->find($bregma_personal->user_rol_id);


            $bregma_personal->fill([
                'estado_registro' => 'A'
            ])->save();
            $celular->fill([
                'estado_registro' => 'A'
            ])->save();
            $correo->fill([
                'estado_registro' => 'A'
            ])->save();
            if ($user_rol) {
                $usuario = User::find($user_rol->user->id);
                $user_rol->fill([
                    'estado_registro' => 'A'
                ])->save();
                $usuario->fill([
                    'estado_registro' => 'A'
                ])->save();
            }
            DB::commit();
            return response()->json(["resp" => "Datos del personal Bregma habilitados"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Muestra todo el personal de bregma
     *  @OA\Get (
     *      path="/api/bregma/personal/get",
     *      summary="Muestra todos los registros de los trabajadores del Bregma logeada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Personal"},
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=3),
     *                      @OA\Property(property="rol_id", type="number", example=6),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
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
     *                          @OA\Property(property="bregma_id", type="number", example=1),
     *                          @OA\Property(property="empresa_id", type="number", example=null),
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
     *                              @OA\Property(property="id", type="number", example=6),
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
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe personal en este bregma"),
     *          )
     *      )
     * )
     */
    public function get()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma_id = $usuario->user_rol[0]->rol->bregma_id;
            $personal_bregma = BregmaPersonal::with(
                'user_rol.user',
                'rol',
                'persona.tipo_documento',
                'persona.distrito.provincia.departamento',
                'persona.distrito_domicilio',
                'persona.estado_civil',
                'persona.religion',
                'persona.sexo',
                'persona.grado_instruccion'
            )->where('estado_registro', 'A')->where('bregma_id', $bregma_id)->get();
            if (count($personal_bregma) == 0) return response()->json(["resp" => "No existe personal en este bregma"]);
            return response()->json(['data' => $personal_bregma, 'size' => count($personal_bregma)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Muestra un personal específico de bregma
     * @OA\Get(
     *      path="/api/bregma/personal/show/{id}",
     *      summary="Muestra todos los datos de un personal de bregma",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Personal"},
     *      @OA\Parameter(description="ID del personal de bregma a visualizar",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=3
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="object",property="data",
     *                  @OA\Property(property="id", type="number", example=3),
     *                  @OA\Property(property="rol_id", type="number", example=6),
     *                  @OA\Property(property="bregma_id", type="number", example=1),
     *                  @OA\Property(property="user_rol_id", type="number", example=3),
     *                  @OA\Property(property="persona_id", type="number", example=5),
     *                  @OA\Property(property="estado_registro", type="string", example="A"),
     *                  @OA\Property(type="object", property="user_rol",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="user_id", type="number", example=3),
     *                      @OA\Property(property="rol_id", type="number", example=6),
     *                      @OA\Property(property="tipo_rol", type="number", example=1),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object", property="user",
     *                          @OA\Property(property="id", type="number", example=3),
     *                          @OA\Property(property="persona_id",type="number", example=5),
     *                          @OA\Property(property="username",type="string", example="48569512" )
     *                      ),
     *                  ),
     *                  @OA\Property(type="object", property="rol",
     *                      @OA\Property(property="id", type="number", example=6),
     *                      @OA\Property(property="nombre", type="string", example="Administrador Bregma"),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=null),
     *                      @OA\Property(property="clinica_id", type="number", example=null),
     *                      @OA\Property(property="tipo_acceso", type="number", example=2),
     *                      @OA\Property(property="estado_registro", type="string", example="AD"),
     *                  ),
     *                  @OA\Property(type="object", property="persona",
     *                      @OA\Property(property="id", type="number", example=5),
     *                      @OA\Property(property="foto", type="file", example=null),
     *                      @OA\Property(property="numero_documento", type="string", example="48569512"),
     *                      @OA\Property(property="nombres", type="string", example="Bernardo"),
     *                      @OA\Property(property="apellido_paterno", type="string", example="Vaca"),
     *                      @OA\Property(property="apellido_materno", type="string", example="zeta"),
     *                      @OA\Property(property="cargo", type="string", example="personal"),
     *                      @OA\Property(property="fecha_nacimiento", type="string", example="2002-04-27"),
     *                      @OA\Property(property="hobbies", type="string", example="futbol"),
     *                      @OA\Property(property="celular", type="string", example="954784545"),
     *                      @OA\Property(property="telefono", type="string", example="2879410"),
     *                      @OA\Property(property="correo", type="string", example="email_prueba@gmail.com"),
     *                      @OA\Property(property="direccion", type="string", example="Av. las fresias 328"),
     *                      @OA\Property(property="telefono_emergencia", type="string", example="2648451"),
     *                      @OA\Property(property="contacto_emergencia", type="string", example="954241548"),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *                      @OA\Property(property="estado_civil_id", type="number", example=1),
     *                      @OA\Property(property="religion_id", type="number", example=1),
     *                      @OA\Property(property="sexo_id", type="number", example=1),
     *                      @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *                      @OA\Property(type="object", property="tipo_documento",
     *                          @OA\Property(property="id", type="number", example=6),
     *                          @OA\Property(property="nombre", type="string", example="DNI"),
     *                          @OA\Property(property="codigo", type="number", example=1),
     *                          @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                      @OA\Property(type="object",property="distrito",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="distrito", type="string", example="MONTEVIDEO"),
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
     *                      @OA\Property(type="object", property="distrito_domicilio",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="descripcion", type="string", example="No hay tabla distrito_domicilio"),
     *                      ),
     *                      @OA\Property(type="object", property="estado_civil",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Soltero(a)"),
     *                      ),
     *                      @OA\Property(type="object", property="religion",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="descripcion", type="string", example="Catolica"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="sexo",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Masculino"),
     *                      ),
     *                      @OA\Property(type="object", property="grado_instruccion",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Primaria"),
     *                      ),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe personal con este ID"),
     *          )
     *      ),
     *      @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El personal pertenece a otro bregma"),
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma_id = $usuario->user_rol[0]->rol->bregma_id;
            $personal_bregma = BregmaPersonal::with(
                'rol',
                'user_rol.user',
                'persona.tipo_documento',
                'persona.distrito.provincia.departamento',
                'persona.distrito_domicilio',
                'persona.estado_civil',
                'persona.religion',
                'persona.sexo',
                'persona.grado_instruccion'
            )->where('estado_registro', 'A')->find($id);
            if (!$personal_bregma) return response()->json(["resp" => "No existe personal con ese ID"]);
            if ($personal_bregma->bregma_id != $bregma_id) return response()->json("El personal pertenece a otro Bregma");
            return response()->json(["data" => $personal_bregma]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Asignar areas a bregma personal
     * @OA\Post(
     *     path="/api/bregma/personal/asignararea",
     *     summary="Asigna un area para varias empresas personales",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Bregma - Personal"},
     *     @OA\Parameter(description="La ID del Bregma Area",@OA\Schema(type="integer"),name="bregma_area_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID de las Bregma Personales",@OA\Schema(type="integer"),name="id",in="query",required=false,example="1"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                     @OA\Property(property="bregma_area_id",type="integer",example="1"),
     *                     @OA\Property(type="array",property="bregma_personales",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id",type="integer",example="1")
     *                         )
     *                     )
     *
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Bregma Areas asignadas correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="error")
     *         )
     *     )
     * )
     */
    public function asignarAreas(Request $request)
    {
        DB::beginTransaction();
        try {

            // $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            // $bregma_id = $usuario->user_rol[0]->rol->bregma_id;
            $bregma_area = BregmaArea::where('estado_registro', 'A')->find($request['bregma_area_id']);

            if (!$bregma_area) return response()->json(["Error:" => "El Bregma Area ingresado no existe"]);
            // return response()->json($bregma_area);
            $bregma_personales = $request->bregma_personales;
            foreach ($bregma_personales as $bregma_personal) {
                $bregma_per = BregmaPersonal::where('id', $bregma_personal['id'])->first();
                if (!$bregma_per) return response()->json(["error" => "Algun Bregma Personal no existe"]);
                $bregma_per->fill([
                    "bregma_area_id" => $bregma_area->id,
                ])->save();
            }
            DB::commit();
            return response()->json(["resp" => "Bregma Areas asignadas correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "" . $e]);
        }
    }

    /**
     * Muestra los personales de un bregma de acuerdo a sus areas
     * @OA\Get(
     *      path="/api/bregma/personal/area/get/{id_area}",
     *      summary="Muestra todos los personales de un bregma respecto a sus areas",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Personal"},
     *      @OA\Parameter(description="ID de area Bregma",
     *          @OA\Schema(type="number"),name="bregma_area",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="object",property="data",
     *                  @OA\Property(property="id", type="number", example=3),
     *                  @OA\Property(property="rol_id", type="number", example=6),
     *                  @OA\Property(property="bregma_id", type="number", example=1),
     *                  @OA\Property(property="user_rol_id", type="number", example=3),
     *                  @OA\Property(property="persona_id", type="number", example=5),
     *                  @OA\Property(property="estado_registro", type="string", example="A"),
     *                  @OA\Property(type="object", property="user_rol",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="user_id", type="number", example=3),
     *                      @OA\Property(property="rol_id", type="number", example=6),
     *                      @OA\Property(property="tipo_rol", type="number", example=1),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object", property="user",
     *                          @OA\Property(property="id", type="number", example=3),
     *                          @OA\Property(property="persona_id",type="number", example=5),
     *                          @OA\Property(property="username",type="string", example="48569512" )
     *                      ),
     *                  ),
     *                  @OA\Property(type="object", property="rol",
     *                      @OA\Property(property="id", type="number", example=6),
     *                      @OA\Property(property="nombre", type="string", example="Administrador Bregma"),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=null),
     *                      @OA\Property(property="clinica_id", type="number", example=null),
     *                      @OA\Property(property="tipo_acceso", type="number", example=2),
     *                      @OA\Property(property="estado_registro", type="string", example="AD"),
     *                  ),
     *                  @OA\Property(type="object", property="persona",
     *                      @OA\Property(property="id", type="number", example=5),
     *                      @OA\Property(property="foto", type="file", example=null),
     *                      @OA\Property(property="numero_documento", type="string", example="48569512"),
     *                      @OA\Property(property="nombres", type="string", example="Bernardo"),
     *                      @OA\Property(property="apellido_paterno", type="string", example="Vaca"),
     *                      @OA\Property(property="apellido_materno", type="string", example="zeta"),
     *                      @OA\Property(property="cargo", type="string", example="personal"),
     *                      @OA\Property(property="fecha_nacimiento", type="string", example="2002-04-27"),
     *                      @OA\Property(property="hobbies", type="string", example="futbol"),
     *                      @OA\Property(property="celular", type="string", example="954784545"),
     *                      @OA\Property(property="telefono", type="string", example="2879410"),
     *                      @OA\Property(property="correo", type="string", example="email_prueba@gmail.com"),
     *                      @OA\Property(property="direccion", type="string", example="Av. las fresias 328"),
     *                      @OA\Property(property="telefono_emergencia", type="string", example="2648451"),
     *                      @OA\Property(property="contacto_emergencia", type="string", example="954241548"),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *                      @OA\Property(property="estado_civil_id", type="number", example=1),
     *                      @OA\Property(property="religion_id", type="number", example=1),
     *                      @OA\Property(property="sexo_id", type="number", example=1),
     *                      @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *                      @OA\Property(type="object", property="tipo_documento",
     *                          @OA\Property(property="id", type="number", example=6),
     *                          @OA\Property(property="nombre", type="string", example="DNI"),
     *                          @OA\Property(property="codigo", type="number", example=1),
     *                          @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                      @OA\Property(type="object",property="distrito",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="distrito", type="string", example="MONTEVIDEO"),
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
     *                      @OA\Property(type="object", property="distrito_domicilio",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="descripcion", type="string", example="No hay tabla distrito_domicilio"),
     *                      ),
     *                      @OA\Property(type="object", property="estado_civil",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Soltero(a)"),
     *                      ),
     *                      @OA\Property(type="object", property="religion",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="descripcion", type="string", example="Catolica"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="sexo",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Masculino"),
     *                      ),
     *                      @OA\Property(type="object", property="grado_instruccion",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Primaria"),
     *                      ),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentar de nuevo ..."),
     *          )
     *      ),
     * )
     */
    public function get_personal_area(Request $request, $id_area)
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $user_bregma = $usuario->id;
            if (!$user_bregma) return response()->json(["error" => "No eres usuario bregma"]);
            $personal_bregma = BregmaPersonal::with(
                'rol',
                'user_rol.user',
                'persona',
                'bregma_area',
            )
                ->where('bregma_area_id', $id_area)
                //->Orwhere('bregma_area_id', null)
                ->get();
            return response()->json(["data" => $personal_bregma, "size" => count($personal_bregma)]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "" . $e]);
        }
    }
}
