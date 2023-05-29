<?php

namespace App\Http\Controllers;

use App\Models\Bregma;
use App\Models\BregmaPersonal;
use App\Models\Celular;
use App\Models\ClinicaPersonal;
use App\Models\Clinica;
use App\Models\ClinicaArea;
use App\Models\Correo;
use App\Models\EmpresaPersonal;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\UserRol;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClinicaPersonalController extends Controller
{
    private $Persona;
    public function __construct(PersonaController $Persona)
    {
        $this->Persona = $Persona;
    }
    /**
     *  Crea un personal de Clinica
     *  @OA\Post (
     *      path="/api/clinica/personal/create",
     *      summary="Crea un personal de Clinica",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
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
     *      @OA\Parameter(description="Direccion",
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
     *      @OA\Parameter(description="ID de la religion",
     *          @OA\Schema(type="number"),name="religion_id",in="query",required= false),
     *      @OA\Parameter(description="ID del sexo o genero",
     *          @OA\Schema(type="number"),name="sexo_id",in="query",required= false),
     *      @OA\Parameter(description="ID del grado de instruccion",
     *          @OA\Schema(type="number"),name="grado_instruccion_id",in="query",required= false),
     *      @OA\Parameter(description="ID del Rol",
     *          @OA\Schema(type="number"),name="rol_id",in="query",required= false,example=1),
     *      @OA\Parameter(description="¿Sera usuario? 0=No 1=Si",
     *          @OA\Schema(type="number"),name="usuario",in="query",required= false,example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="tipo_documento_id",type="foreignId"),
     *                      @OA\Property(property="numero_documento",type="string"),
     *                      @OA\Property(property="nombres",type="string"),
     *                      @OA\Property(property="apellido_paterno",type="string"),
     *                      @OA\Property(property="apellido_materno", type="string"),
     *                      @OA\Property(property="cargo", type="string"),
     *                      @OA\Property(property="fecha_nacimiento", type="string"),
     *                      @OA\Property(property="hobbies", type="string"),
     *                      @OA\Property(property="celular",type="string"),
     *                      @OA\Property(property="telefono",type="string"),
     *                      @OA\Property(property="correo",type="string"),
     *                      @OA\Property(property="direccion",type="string"),
     *                      @OA\Property(property="telefono_emergencia",type="string"),
     *                      @OA\Property(property="contacto_emergencia",type="string"),
     *                      @OA\Property(property="rol_id",type="foreignId"),
     *                      @OA\Property(property="usuario",type="string"),
     *                      @OA\Property(property="distrito_id",type="foreignId"),
     *                      @OA\Property(property="distrito_domicilio_id",type="foreignId"),
     *                      @OA\Property(property="estado_civil_id",type="foreignId"),
     *                      @OA\Property(property="religion_id",type="foreignId"),
     *                      @OA\Property(property="sexo_id",type="foreignId"),
     *                      @OA\Property(property="grado_instruccion_id",type="foreignId"),
     *                      @OA\Property(property="clinica_area_id",type="foreignId"),
     *                  ),
     *                  example={
     *                      "tipo_documento_id": 1,
     *                      "numero_documento": "65656565",
     *                      "nombres": "Juan",
     *                      "apellido_paterno": "Perez",
     *                      "apellido_materno": "Palomino",
     *                      "cargo": "personal",
     *                      "fecha_nacimiento": "2002-04-27",
     *                      "hobbies": "futbol",
     *                      "celular": "987654321",
     *                      "telefono": "013245678",
     *                      "correo": "juan@example.com",
     *                      "direccion": "Calle Los Pinos 123",
     *                      "telefono_emergencia": "012345678",
     *                      "contacto_emergencia": "Maria Perez",
     *                      "distrito_id": 1,
     *                      "distrito_domicilio_id": 2,
     *                      "estado_civil_id": 1,
     *                      "religion_id": 3,
     *                      "sexo_id": 1,
     *                      "grado_instruccion_id": 4,
     *                      "clinica_area_id": 1,
     *                      "rol_id": 2,
     *                      "usuario": 1,
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Personal creado correctamente")
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
            $persona = Persona::where('numero_documento',$request->numero_documento)->first();
            if ($persona) {
                $existe_personal_empresa = EmpresaPersonal::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
                $existe_personal_bregma = BregmaPersonal::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
                $existe_personal_clinica = ClinicaPersonal::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
                if ($existe_personal_empresa || $existe_personal_bregma || $existe_personal_clinica) return response()->json(["error" => "Ya existe otro registro con el numero de documento"], 500);
            }
            $rol = Rol::find($request->rol_id);
            if (!$rol) return response()->json(["error" => "No existe rol con el id ingresado"], 501);
            $acceso_rol = Rol::where('clinica_id', $datos->user_rol[0]->rol->clinica_id)->find($rol->id);
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required',
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'rol_id' => 'required',
                'usuario' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if (!$acceso_rol) return response()->json(["error" => "No tiene acceso al rol"], 502);
            $persona = $this->Persona->store($request);
            if ($request->usuario == 0) {
                $clinica_personal = ClinicaPersonal::updateOrCreate([
                    'clinica_id' => $datos->user_rol[0]->rol->clinica_id,
                    'persona_id' => $persona->id
                ], [
                    'clinica_area_id'=>$request->clinica_area_id,
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
                $clinica_personal = ClinicaPersonal::updateOrCreate([
                    'clinica_id' => $datos->user_rol[0]->rol->clinica_id,
                    'user_rol_id' => $user_rol->id,
                    'persona_id' => $persona->id
                ], [
                    'clinica_area_id'=>$request->clinica_area_id,
                    'rol_id' => $request->rol_id,
                    'estado_registro' => 'A'
                ]);
            }
            DB::commit();
            return response()->json(["resp" => "Personal creado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
    /**
     *  Actualiza un registro del personal de la Clinica segun el id de la ruta
     *  @OA\Put (
     *      path="/api/clinica/personal/update/{id}",
     *      summary="Actualiza un registro del personal de la Clinica segun el id de la ruta",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
     *      @OA\Parameter(description="ID del personal Clinica",
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
     *                      @OA\Property(property="clinica_area_id",type="foreignId"),
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
     *                     "clinica_area_id": 1,
     *                     "rol_id":1,
     *                     "usuario":1
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
            $clinica_personal = ClinicaPersonal::find($id);
            if (!$clinica_personal) return response()->json(["resp" => "No existen registros con este id"], 500);
            // return response()->json($clinica_personal);
            $persona = Persona::find($clinica_personal->persona_id);
            $usuario = User::with('user_rol')->where('username', $persona->numero_documento)->first();
            $rol = Rol::find($request->rol_id);
            $acceso_rol = Rol::where('clinica_id', $datos->user_rol[0]->rol->clinica_id)->find($request->rol_id);
            $dni = Persona::where("numero_documento", $request->numero_documento)->where("id", '!=', $persona->id)->first();
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required',
                'nombres' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'rol_id' => 'required',
                'usuario' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if ($dni) return response()->json(["error" => "Otro registro ya cuenta con el numero de documento"], 501);
            if (!$rol) return response()->json(["error" => "No existe rol con ese id"], 502);
            if (!$acceso_rol) return response()->json(["error" => "No tiene acceso al rol"], 503);
            //
            $persona = $this->Persona->update($request,$persona->id);
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

                    $clinica_personal->fill([
                        'clinica_area_id'=>$request->clinica_area_id,
                        'rol_id' => $request->rol_id,
                        'clinica_id' => $rol->clinica_id,
                        'persona_id' => $persona->id,
                        'user_rol_id' => null
                    ])->save();
                }
                $clinica_personal->fill([
                    'clinica_area_id'=>$request->clinica_area_id,
                    'rol_id' => $request->rol_id,
                    'clinica_id' => $rol->clinica_id,
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
                $clinica_personal = ClinicaPersonal::updateOrCreate([
                    'persona_id' => $persona->id
                ], [
                    'clinica_area_id'=>$request->clinica_area_id,
                    'rol_id' => $request->rol_id,
                    'clinica_id' => $rol->clinica_id,
                    'user_rol_id' => $user_rol->id,
                ]);
            }
            DB::commit();
            return response()->json(["resp" => "Datos del personal Clínica actualizados"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
    /**
     *  Deshabilita del personal de Clinica
     *  @OA\Delete(
     *      path="/api/clinica/personal/delete/{id}",
     *      summary="Deshabilita el registro del personal clinica teniendo como parametro el id del personal bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
     *      @OA\Parameter(description="ID del registro del personal",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Personal eliminado.")
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="ERROR"),
     *          )
     *      ),
     *  )
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $clinica_personal = ClinicaPersonal::find($id);
            $persona = Persona::find($clinica_personal->persona_id);
            $celular = Celular::where('persona_id', $persona->id)->first();
            $correo = Correo::where('persona_id', $persona->id)->first();
            $user_rol = UserRol::with('user')->find($clinica_personal->user_rol_id);
            if (!$clinica_personal) return response()->json(["error" => "No existen registros con este ID"], 500);
            $clinica_personal->fill([
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
            return response()->json(["resp" => "Datos del Personal Clinica inhabilitados"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    /**
     *  Elimina por completo al personal de Clinica
     *  @OA\Delete(
     *      path="/api/clinica/personal/destroy/{id}",
     *      summary="Elimina de la BD al registro del personal clinica teniendo como parametro el id del personal bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
     *      @OA\Parameter(description="ID del registro del personal clinica",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Personal eliminado.")
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="ERROR"),
     *          )
     *      ),
     *  )
     */
    public function destroy($id){
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $user->user_rol[0]->rol->clinica_id;
            if (!$clinica_id) return response()->json(["error" => "No inicio sesión como clinica"]);
            $clinica_personal = ClinicaPersonal::find($id);
            if (!$clinica_personal) return response()->json(["error" => "No existe el personal"]);
            $clinica_personal->fill([
                "clinica_area_id" => null,
                "rol_id" => null,
                "clinica_id" => null,
                "user_rol_id" => null,
                "persona_id" => null,
            ]);
            $clinica_personal->save();
            $clinica_personal->delete();
            return response()->json(["Personal Eliminado exitosamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Activar datos del personal de Clinica
     *  @OA\Put (
     *      path="/api/clinica/personal/activar/{id}",
     *      summary="Habilita el registro del personal clinica teniendo como parametro el id del personal con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
     *      @OA\Parameter(description="ID del registro del personal",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos del personal Clinica habilitadas"),
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
            $clinica_personal = ClinicaPersonal::find($id);
            $persona = Persona::find($clinica_personal->persona_id);
            $celular = Celular::where('persona_id', $persona->id)->first();
            $correo = Correo::where('persona_id', $persona->id)->first();
            $user_rol = UserRol::with('user')->find($clinica_personal->user_rol_id);
            if (!$clinica_personal) return response()->json(["error" => "No existe un personal con este ID"]);
            $clinica_personal->fill([
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
            return response()->json(["resp" => "Datos del Personal Clinica habilitados"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Muestra todos los registros de Clinica
     *  @OA\Get (
     *      path="/api/clinica/personal/get",
     *      summary="Muestra todo el personal de Clinica que esta con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=3),
     *                      @OA\Property(property="rol_id", type="number", example=6),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
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
     *                          @OA\Property(property="empresa_id", type="number", example=null),
     *                          @OA\Property(property="clinica_id", type="number", example=1),
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
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe personal en esta Clínica"),
     *          )
     *      )
     *  )
     */
    public function get()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            $clinica_personal = ClinicaPersonal::with(
                'user_rol.user',
                'rol',
                'persona.tipo_documento',
                'persona.distrito.provincia.departamento',
                'persona.distrito_domicilio',
                'persona.estado_civil',
                'persona.religion',
                'persona.sexo',
                'persona.grado_instruccion',
                'clinica_area'
            )->where('clinica_id', $clinica_id)->get();
            if (count($clinica_personal) == 0) return response()->json(["resp" => "No existe personal en esta Clinica"]);
            return response()->json(['data' => $clinica_personal, 'size' => count($clinica_personal)]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Muestra los datos de un personal de la Clinica segun el id de la ruta
     *  @OA\Get (
     *      path="/api/clinica/personal/show/{id}",
     *      summary="Muestra un registro del personal de la Clinica segun el id de la ruta",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
     *      @OA\Parameter(description="ID del personal de clinica",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=3),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="object",property="data",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="rol_id", type="integer", example=2),
     *                  @OA\Property(property="clinica_id", type="integer", example=1),
     *                  @OA\Property(property="user_rol_id", type="integer", example=3),
     *                  @OA\Property(property="persona_id", type="integer", example=3),
     *                  @OA\Property(property="estado_registro", type="char", example="A"),
     *                  @OA\Property(type="object", property="user_rol",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="user_id", type="number", example=3),
     *                      @OA\Property(property="rol_id", type="number", example=6),
     *                      @OA\Property(property="tipo_rol", type="number", example=1),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object", property="user",
     *                          @OA\Property(property="id", type="number", example=3),
     *                          @OA\Property(property="persona_id",type="number", example=5),
     *                          @OA\Property(property="username",type="string", example="48569512"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                  ),
     *                  @OA\Property(type="object", property="rol",
     *                      @OA\Property(property="id", type="number", example=2),
     *                      @OA\Property(property="nombre", type="string", example="Administrador Clinica"),
     *                      @OA\Property(property="bregma_id", type="integer", example=null),
     *                      @OA\Property(property="empresa_id", type="integer", example=null),
     *                      @OA\Property(property="clinica_id", type="integer", example=2),
     *                      @OA\Property(property="tipo_acceso", type="number", example=3),
     *                      @OA\Property(property="estado_registro", type="char", example="SU")
     *                  ),
     *                  @OA\Property(type="object", property="persona",
     *                      @OA\Property(property="id", type="number", example=3),
     *                      @OA\Property(property="foto", type="string", example=null),
     *                      @OA\Property(property="numero_documento", type="integer", example="33333333"),
     *                      @OA\Property(property="nombres", type="string", example="Ruben"),
     *                      @OA\Property(property="apellido_paterno", type="string", example="Perez"),
     *                      @OA\Property(property="apellido_materno", type="string", example="Garcia"),
     *                      @OA\Property(property="cargo", type="string", example="personal"),
     *                      @OA\Property(property="fecha_nacimiento", type="date", example="1990-05-15"),
     *                      @OA\Property(property="hobbies", type="string", example="futbolista"),
     *                      @OA\Property(property="celular", type="number", example=966666662),
     *                      @OA\Property(property="telefono", type="number", example=013245678),
     *                      @OA\Property(property="correo", type="string", example="willy@example.com"),
     *                      @OA\Property(property="direccion", type="string", example="Calle Los Pinos 123"),
     *                      @OA\Property(property="telefono_emergencia", type="integer", example="012345678"),
     *                      @OA\Property(property="contacto_emergencia", type="string", example="Maria Perez"),
     *                      @OA\Property(property="tipo_documento_id", type="integer", example=1),
     *                      @OA\Property(property="distrito_id", type="integer", example=1),
     *                      @OA\Property(property="distrito_domicilio_id", type="integer", example=2),
     *                      @OA\Property(property="estado_civil_id", type="integer", example=1),
     *                      @OA\Property(property="religion_id", type="integer", example=3),
     *                      @OA\Property(property="sexo_id", type="integer", example=1),
     *                      @OA\Property(property="grado_instruccion_id", type="integer", example=4),
     *                      @OA\Property(type="object", property="tipo_documento",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="DNI"),
     *                          @OA\Property(property="codigo", type="char", example=""),
     *                          @OA\Property(property="descripcion", type="integer", example="Documento Nacional de Identidad"),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="distrito",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="distrito", type="string", example="CHACHAPOYAS"),
     *                          @OA\Property(property="provincia_id", type="integer", example=1),
     *                          @OA\Property(type="object", property="provincia",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                              @OA\Property(property="departamento_id", type="integer", example=1),
     *                              @OA\Property(type="object", property="departamento",
     *                                  @OA\Property(property="id", type="number", example=1),
     *                                  @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                              ),
     *                          ),
     *                      ),
     *                      @OA\Property(property="distrito_domicilio", type="string", example=null),
     *                      @OA\Property(type="object", property="estado_civil",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Soltero(a)"),
     *                      ),
     *                      @OA\Property(type="object", property="religion",
     *                          @OA\Property(property="id", type="number", example=3),
     *                          @OA\Property(property="descripcion", type="string", example="Musulmán"),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="sexo",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Masculino"),
     *                      ),
     *                      @OA\Property(type="object", property="grado_instruccion",
     *                          @OA\Property(property="id", type="number", example=4),
     *                          @OA\Property(property="nombre", type="string", example="Secundaria Incompleta"),
     *                      ),
     *                  ),
     *                  
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existe personal con ese ID"),
     *          )
     *      ),
     *      @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El personal pertenece a otra Clinica"),
     *          )
     *      )
     *  )
     */
    public function show($id)
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            $clinica_personal = ClinicaPersonal::with(
                'user_rol.user',
                'rol',
                'persona.tipo_documento',
                'persona.distrito.provincia.departamento',
                'persona.distrito_domicilio',
                'persona.estado_civil',
                'persona.religion',
                'persona.sexo',
                'persona.grado_instruccion',
                'clinica_area'
            )->find($id);
            if (!$clinica_personal) return response()->json(["resp" => "No existe personal con ese ID"],500);
            if ($clinica_personal->clinica_id != $clinica_id) return response()->json(["resp" => "El personal pertenece a otra Clinica"],501);
            return response()->json(["data"=>$clinica_personal]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Asignar areas a Clinica personal
     * @OA\Post(
     *     path="/api/clinica/personal/asignararea",
     *     summary="Asigna un area para varias clinica personales",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Clinica-Personal"},
     *     @OA\Parameter(description="La ID del Clinica Area",@OA\Schema(type="integer"),name="clinica_area_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID de las Clinica Personales",@OA\Schema(type="integer"),name="id",in="query",required=false,example="1"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                     @OA\Property(property="clinica_area_id",type="integer",example="1"),
     *                     @OA\Property(type="array",property="clinica_personales",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id",type="integer",example="1")
     *                         )
     *                     )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Clinica Areas asignadas correctamente")
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
    public function asignarAreas(Request $request){
        DB::beginTransaction();
        try {
            $clinica_area = ClinicaArea::where('estado_registro', 'A')->find($request['clinica_area_id']);
            // return response()->json($rol);
            if(!$clinica_area) return response()->json(["Error:"=>"El Clinica Area ingresado no existe"]);

            $clinica_personales = $request->clinica_personales;
            foreach ($clinica_personales as $clinica_personal ) {
                $clinica_per=ClinicaPersonal::where('id',$clinica_personal['id'])->first();
                if(!$clinica_per) return response()->json(["error"=>"Clinica Personal no existe"]);
                $clinica_per->fill([
                    "clinica_area_id"=>$clinica_area->id,
                ])->save();
            }
            DB::commit();
            return response()->json(["resp" => "Clinica Areas asignadas correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "".$e]);
        }
    }


    /**
     *  Muestra los personales de una Clinica respecto a sus areas
     *  @OA\Get (
     *      path="/api/clinica/personal/area/get/{id_area}",
     *      summary="Muestra los personales de una Clinica respecto a sus areas",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Clinica-Personal"},
     *      @OA\Parameter(description="ID del area de clinica",
     *          @OA\Schema(type="number"),name="clinica_area",in="path",required= true,example=3),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="object",property="data",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="rol_id", type="integer", example=2),
     *                  @OA\Property(property="clinica_id", type="integer", example=1),
     *                  @OA\Property(property="user_rol_id", type="integer", example=3),
     *                  @OA\Property(property="persona_id", type="integer", example=3),
     *                  @OA\Property(property="estado_registro", type="char", example="A"),
     *                  @OA\Property(type="object", property="user_rol",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="user_id", type="number", example=3),
     *                      @OA\Property(property="rol_id", type="number", example=6),
     *                      @OA\Property(property="tipo_rol", type="number", example=1),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="object", property="user",
     *                          @OA\Property(property="id", type="number", example=3),
     *                          @OA\Property(property="persona_id",type="number", example=5),
     *                          @OA\Property(property="username",type="string", example="48569512"),
     *                          @OA\Property(property="estado_registro", type="string", example="A"),
     *                      ),
     *                  ),
     *                  @OA\Property(type="object", property="rol",
     *                      @OA\Property(property="id", type="number", example=2),
     *                      @OA\Property(property="nombre", type="string", example="Administrador Clinica"),
     *                      @OA\Property(property="bregma_id", type="integer", example=null),
     *                      @OA\Property(property="empresa_id", type="integer", example=null),
     *                      @OA\Property(property="clinica_id", type="integer", example=2),
     *                      @OA\Property(property="tipo_acceso", type="number", example=3),
     *                      @OA\Property(property="estado_registro", type="char", example="SU")
     *                  ),
     *                  @OA\Property(type="object", property="persona",
     *                      @OA\Property(property="id", type="number", example=3),
     *                      @OA\Property(property="foto", type="string", example=null),
     *                      @OA\Property(property="numero_documento", type="integer", example="33333333"),
     *                      @OA\Property(property="nombres", type="string", example="Ruben"),
     *                      @OA\Property(property="apellido_paterno", type="string", example="Perez"),
     *                      @OA\Property(property="apellido_materno", type="string", example="Garcia"),
     *                      @OA\Property(property="cargo", type="string", example="personal"),
     *                      @OA\Property(property="fecha_nacimiento", type="date", example="1990-05-15"),
     *                      @OA\Property(property="hobbies", type="string", example="futbolista"),
     *                      @OA\Property(property="celular", type="number", example=966666662),
     *                      @OA\Property(property="telefono", type="number", example=013245678),
     *                      @OA\Property(property="correo", type="string", example="willy@example.com"),
     *                      @OA\Property(property="direccion", type="string", example="Calle Los Pinos 123"),
     *                      @OA\Property(property="telefono_emergencia", type="integer", example="012345678"),
     *                      @OA\Property(property="contacto_emergencia", type="string", example="Maria Perez"),
     *                      @OA\Property(property="tipo_documento_id", type="integer", example=1),
     *                      @OA\Property(property="distrito_id", type="integer", example=1),
     *                      @OA\Property(property="distrito_domicilio_id", type="integer", example=2),
     *                      @OA\Property(property="estado_civil_id", type="integer", example=1),
     *                      @OA\Property(property="religion_id", type="integer", example=3),
     *                      @OA\Property(property="sexo_id", type="integer", example=1),
     *                      @OA\Property(property="grado_instruccion_id", type="integer", example=4),
     *                      @OA\Property(type="object", property="tipo_documento",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="DNI"),
     *                          @OA\Property(property="codigo", type="char", example=""),
     *                          @OA\Property(property="descripcion", type="integer", example="Documento Nacional de Identidad"),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="distrito",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="distrito", type="string", example="CHACHAPOYAS"),
     *                          @OA\Property(property="provincia_id", type="integer", example=1),
     *                          @OA\Property(type="object", property="provincia",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                              @OA\Property(property="departamento_id", type="integer", example=1),
     *                              @OA\Property(type="object", property="departamento",
     *                                  @OA\Property(property="id", type="number", example=1),
     *                                  @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                              ),
     *                          ),
     *                      ),
     *                      @OA\Property(property="distrito_domicilio", type="string", example=null),
     *                      @OA\Property(type="object", property="estado_civil",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Soltero(a)"),
     *                      ),
     *                      @OA\Property(type="object", property="religion",
     *                          @OA\Property(property="id", type="number", example=3),
     *                          @OA\Property(property="descripcion", type="string", example="Musulmán"),
     *                          @OA\Property(property="estado_registro", type="char", example="A"),
     *                      ),
     *                      @OA\Property(type="object", property="sexo",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="nombre", type="string", example="Masculino"),
     *                      ),
     *                      @OA\Property(type="object", property="grado_instruccion",
     *                          @OA\Property(property="id", type="number", example=4),
     *                          @OA\Property(property="nombre", type="string", example="Secundaria Incompleta"),
     *                      ),
     *                  ),
     *                  
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentar de nuevo"),
     *          )
     *      ),
     *  )
     */
    public function get_personal_area(Request $request, $id_area){
        try{
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $personal_clinica = ClinicaPersonal::with(
                'rol',
                'user_rol.user',
                'persona',
                'clinica_area',
            )
            ->where('clinica_area_id',$id_area)
            ->Orwhere('clinica_area_id',null)
            ->get();
            return response()->json(["data" => $personal_clinica, "size" => count($personal_clinica)]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["error" => "".$e]);
        }
    }
}
