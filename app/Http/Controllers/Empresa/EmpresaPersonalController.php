<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonaController;
use App\Models\BregmaPersonal;
use App\Models\Celular;
use App\Models\ClinicaPersonal;
use App\Models\ClinicaServicio;
use App\Models\Correo;
use App\Models\Empresa;
use App\Models\EmpresaArea;
use App\Models\EmpresaPersonal;
use App\Models\HojaRuta;
use App\Models\HojaRutaDetalle;
use App\Models\Paciente;
use App\Models\PerfilTipo;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\TipoPerfil;
use App\Models\UserRol;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmpresaPersonalController extends Controller
{
    private $Persona;
    public function __construct(PersonaController $Persona)
    {
        $this->Persona = $Persona;
    }
    /**
     *  Crear personal de empresa
     *  @OA\Post (
     *      path="/api/empresa/personal/create",
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
     *      @OA\Parameter(
     *          @OA\Schema(type="integer"),name="usuario",in="query",required= false,example=1),
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
     *                      @OA\Property(property="usuario",type="string"),
     *                      @OA\Property(property="distrito_id",type="foreignId"),
     *                      @OA\Property(property="distrito_domicilio_id",type="foreignId"),
     *                      @OA\Property(property="estado_civil_id",type="foreignId"),
     *                      @OA\Property(property="religion_id",type="foreignId"),
     *                      @OA\Property(property="sexo_id",type="foreignId"),
     *                      @OA\Property(property="grado_instruccion_id",type="foreignId"),
     *                      @OA\Property(property="empresa_area_id",type="foreignId")
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
     *                          "empresa_area_id": 1,
     *                          "rol_id": 2,
     *                          "usuario": 1,
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
            if (!$rol) return response()->json(["error" => "No existe rol con el id ingresado"], 501);
            $acceso_rol = Rol::where('empresa_id', $datos->user_rol[0]->rol->empresa_id)->find($rol->id);
            // return response()->json($request);
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
                $empresa_personal = EmpresaPersonal::updateOrCreate([
                    'empresa_id' => $datos->user_rol[0]->rol->empresa_id,
                    'persona_id' => $persona->id
                ], [
                    'empresa_area_id' => $request->empresa_area_id,
                    'rol_id' => $request->rol_id,
                    'estado_registro' => 'A',
                    'estado_reclutamiento' => 1
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
                $empresa_personal = EmpresaPersonal::updateOrCreate([
                    'empresa_id' => $datos->user_rol[0]->rol->empresa_id,
                    'user_rol_id' => $user_rol->id,
                    'persona_id' => $persona->id
                ], [
                    'empresa_area_id' => $request->empresa_area_id,
                    'rol_id' => $request->rol_id,
                    'estado_registro' => 'A',
                    'estado_reclutamiento' => 1
                ]);
            }
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
     *      path="/api/empresa/personal/update/{id}",
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
     *                      @OA\Property(property="empresa_area_id", type="number"),
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
     *                     "empresa_area_id": 1,
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
                'usuario' => 'required',
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if ($dni) return response()->json(["error" => "Otro registro ya cuenta con el numero de documento"], 501);
            if (!$rol) return response()->json(["error" => "No existe rol con ese id"], 502);
            if (!$acceso_rol) return response()->json(["error" => "No tiene acceso al rol"], 503);

            $this->Persona->update($request, $empresa_personal->persona_id);
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

                    $empresa_personal->fill([
                        'empresa_area_id' => $request->empresa_area_id,
                        'rol_id' => $request->rol_id,
                        'empresa_id' => $rol->empresa_id,
                        'persona_id' => $persona->id,
                        'user_rol_id' => null
                    ])->save();
                }
                $empresa_personal->fill([
                    'empresa_area_id' => $request->empresa_area_id,
                    'rol_id' => $request->rol_id,
                    'empresa_id' => $rol->empresa_id,
                    'persona_id' => $persona->id,
                    'user_rol_id' => null,
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
                $empresa_personal = EmpresaPersonal::updateOrCreate([
                    'persona_id' => $persona->id
                ], [
                    'empresa_area_id' => $request->empresa_area_id,
                    'rol_id' => $request->rol_id,
                    'empresa_id' => $rol->empresa_id,
                    'user_rol_id' => $user_rol->id,
                ]);
            }
            DB::commit();
            return response()->json(["resp" => "Datos del personal Empresa actualizados"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Deshabilita del personal de Empresa
     *  @OA\Delete(
     *      path="/api/empresa/personal/delete/{id}",
     *      summary="Deshabilita el registro del personal empresa teniendo como parametro el id del personal bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Parameter(description="ID del registro del personal empresa",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Personal eliminado.")
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="No existen registros con este ID"),
     *          )
     *      ),
     *  )
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $empresa_personal = EmpresaPersonal::find($id);
            $persona = Persona::find($empresa_personal->persona_id);
            $celular = Celular::where('persona_id', $persona->id)->first();
            $correo = Correo::where('persona_id', $persona->id)->first();
            $user_rol = UserRol::with('user')->find($empresa_personal->user_rol_id);
            if (!$empresa_personal) return response()->json(["error" => "No existen registros con este ID"]);
            $empresa_personal->fill([
                'estado_registro' => 'I',
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
            return response()->json(["resp" => "Datos del Personal Empresa inhabilitados"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Muestra todos los registros de Empresa
     *  @OA\Get (
     *      path="/api/empresa/personal/get",
     *      summary="Muestra todo el personal de Empresa que esta con sesión iniciada",
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
                ->where('estado_reclutamiento', 1)
                ->where('estado_registro', 'A')->get();
            if (count($empresa_personal) == 0) return response()->json(["resp" => "No existe personal en esta Empresa"]);
            return response()->json(['data' => $empresa_personal, 'size' => count($empresa_personal)]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     *  Muestra los datos de un personal de la empresa segun el id de la ruta
     *  @OA\Get (
     *      path="/api/empresa/personal/show/{id}",
     *      summary="Muestra un registro del personal de la empresa segun el id de la ruta",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Parameter(description="ID del personal de empresa",
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
     *                      @OA\Property(property="nombre", type="string", example="Administrador Empresa"),
     *                      @OA\Property(property="bregma_id", type="integer", example=null),
     *                      @OA\Property(property="empresa_id", type="integer", example=2),
     *                      @OA\Property(property="clinica_id", type="integer", example=null),
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
     *              @OA\Property(property="resp", type="string", example="El personal pertenece a otra Empresa"),
     *          )
     *      )
     *  )
     */
    public function show($id)
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
            )->find($id);
            if (!$empresa_personal) return response()->json(["resp" => "No existe personal con ese ID"], 500);
            if ($empresa_personal->empresa_id != $empresa_id) return response()->json(["resp" => "El personal pertenece a otra Empresa"], 501);
            return response()->json(["data" => $empresa_personal]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     *  Elimina por completo del personal de Empresa
     *  @OA\Delete(
     *      path="/api/empresa/personal/destroy/{id}",
     *      summary="Elimina por completo al personal empresa teniendo como parametro el id del personal empresa con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Parameter(description="ID del registro del personal empresa",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Personal eliminado de la base de datos.")
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="No existen registros con este ID"),
     *          )
     *      ),
     *  )
     */
    public function destroy($id)
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $empresa_id = $user->user_rol[0]->rol->empresa_id;
            if (!$empresa_id) return response()->json(["error" => "No inicio sesión como empresa"]);
            $empresa_personal = EmpresaPersonal::find($id);
            if (!$empresa_personal) return response()->json(["error" => "No existe el personal"]);
            $empresa_personal->fill([
                "empresa_area_id" => null,
                "rol_id" => null,
                "empresa_id" => null,
                "user_rol_id" => null,
                "persona_id" => null,
            ]);
            $empresa_personal->save();
            $empresa_personal->delete();
            return response()->json(["Personal Eliminado exitosamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }

        //return response()->json($empresa_personal);
    }
    /**
     *  Activar datos del personal de Empresa
     *  @OA\Put (
     *      path="/api/empresa/personal/activar/{id}",
     *      summary="Habilita el registro del personal empresa teniendo como parametro el id del personal con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Parameter(description="ID del registro del personal",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=2),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos del personal Empresa habilitadas"),
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
            $empresa_personal = EmpresaPersonal::find($id);
            $persona = Persona::find($empresa_personal->persona_id);
            $celular = Celular::where('persona_id', $persona->id)->first();
            $correo = Correo::where('persona_id', $persona->id)->first();
            $user_rol = UserRol::with('user')->find($empresa_personal->user_rol_id);
            if (!$empresa_personal) return response()->json(["error" => "No existe un personal con este ID"]);
            $empresa_personal->fill([
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
            return response()->json(["resp" => "Datos del Personal Empresa habilitados"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    public function enviarTrabajador(Request $request)
    {
        $personales = $request->empresa_personal;
        foreach ($personales as $personal) {
            Paciente::create([
                'empresa_personal_id' => $personal['id']
            ]);
        }
        return response()->json(["resp" => "creado correctamente"]);
    }

    /**
     *
     */
    /* public function getClinicaServicios($id)
    {
        try {
            $empresaPersonal = EmpresaPersonal::find($id);

            $hr = HojaRuta::with('empresa_personal', 'clinica')->where('estado_registro', 'A')->first();
            //return response()->json($hr);
            $hrd = HojaRutaDetalle::with('hoja_ruta', 'clinica_servicio')->where('hoja_ruta_id', $hr->id)->where('estado_registro', 'A')->first();
            //return response()->json($hrd);

            //return response()->json($hr);
            //$emp = EmpresaPersonal::where('id', $hr->empresa_personal->id)->first();
            //return response()->json($emp);
            $servicios = ClinicaServicio::where('id', $hrd->clinica_servicio->id)->where('estado_registro', 'A')->get();

            return response()->json(["data"=>$servicios]);
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }*/
    public function getClinicaServicios($id)
    {
        try {
            $empresaPersonal = EmpresaPersonal::find($id);

            if (!$empresaPersonal) {
                return response()->json(["resp" => "No se encontró el empresa personal o no existe."]);
            }

            $clinicaId = $empresaPersonal->empresa->clinica_id;
            $servicios = ClinicaServicio::where('clinica_id', $clinicaId)->where('estado_registro', 'A')->get();

            $hojasRuta = HojaRuta::with('empresa_personal', 'clinica')
                ->where('empresa_personal_id', $empresaPersonal->id)
                ->where('estado_registro', 'A')
                ->get();

            $servicios = collect();
            foreach ($hojasRuta as $hojaRuta) {
                $detalles = HojaRutaDetalle::with('hoja_ruta', 'clinica_servicio')
                    ->where('hoja_ruta_id', $hojaRuta->id)
                    ->where('estado_registro', 'A')
                    ->get();

                foreach ($detalles as $detalle) {
                    $servicios->push($detalle->clinica_servicio);
                }
            }
            return response()->json(["data" => $servicios]);
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    public function asignar_perfil(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario_clinica = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            //$tipo_perfil = TipoPerfil::find($request->tipo_perfil);
            //$empresa_personal = EmpresaPersonal::find($request->empresa_personal);
            $perfil_tipo = PerfilTipo::with(['areas_medicas', 'examen', 'capacitaciones', 'laboratorios'])->find($request->perfil_tipo_id);
            foreach ($request->empresa_personales as $empresa_personal_id) {
                $empresa_personal = EmpresaPersonal::find($empresa_personal_id['empresa_personal_id']);
                $hoja_ruta = HojaRuta::updateOrCreate([
                    "empresa_personal_id" => $empresa_personal->id,
                    "perfil_tipo_id" => $perfil_tipo->id,
                    "clinica_id" => $request->clinica_id,
                ]);

                //foreach
                $paciente = Paciente::updateOrCreate([
                    "empresa_personal_id" => $empresa_personal->id,
                    "persona_id" => $empresa_personal->persona_id,
                    "hoja_ruta_id" => $hoja_ruta->id,
                    "fecha" => $request->fecha,
                    "clinica_id" => $request->clinica_id,
                    "clinica_local_id" => $request->clinica_local_id,
                ]);
                $areas_medicas = $perfil_tipo->areas_medicas;
                $capacitaciones = $perfil_tipo->capacitaciones;
                $laboratorios = $perfil_tipo->laboratorios;
                $examenes = $perfil_tipo->examen;

                if ($areas_medicas) {
                    foreach ($areas_medicas as $area_medica) {
                        $hoja_ruta_detalle = HojaRutaDetalle::updateOrCreate([
                            "hoja_ruta_id" => $hoja_ruta->id,
                            "area_medica_id" => $area_medica['id'],
                            "estado_ruta_id" => 1
                        ]);
                    }
                }
                if ($capacitaciones) {
                    foreach ($capacitaciones as $capacitacion) {
                        $hoja_ruta_detalle = HojaRutaDetalle::updateOrCreate([
                            "hoja_ruta_id" => $hoja_ruta->id,
                            "capacitacion_id" => $capacitacion['id'],
                            "estado_ruta_id" => 1
                        ]);
                    }
                }
                if ($laboratorios) {
                    foreach ($laboratorios as $laboratorio) {
                        $hoja_ruta_detalle = HojaRutaDetalle::updateOrCreate([
                            "hoja_ruta_id" => $hoja_ruta->id,
                            "laboratorio_id" => $laboratorio['id'],
                            "estado_ruta_id" => 1
                        ]);
                    }
                }
                if ($examenes) {
                    foreach ($examenes as $examen) {
                        $hoja_ruta_detalle = HojaRutaDetalle::updateOrCreate([
                            "hoja_ruta_id" => $hoja_ruta->id,
                            "examen_id" => $examen['id'],
                            "estado_ruta_id" => 1
                        ]);
                    }
                }
                // return response()->json([$areas_medicas, $capacitaciones, $laboratorios, $examenes]);
            }
            DB::commit();
            return response()->json(["resp" => "Asignado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
    /**
     * Asignar areas a Empresa personal
     * @OA\Post(
     *     path="/api/empresa/personal/asignararea",
     *     summary="Asigna un area para varias empresas personales",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Empresa-Personal"},
     *     @OA\Parameter(description="La ID del Empresa Area",@OA\Schema(type="integer"),name="empresa_area_id",in="query",required=true,example="1"),
     *     @OA\Parameter(description="La ID de las Empresa Personales",@OA\Schema(type="integer"),name="id",in="query",required=false,example="1"),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                     @OA\Property(property="empresa_area_id",type="integer",example="1"),
     *                     @OA\Property(type="array",property="empresa_personales",
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
     *             @OA\Property(property="msg", type="string", example="Empresa Areas asignadas correctamente")
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
            $empresa_area = EmpresaArea::where('estado_registro', 'A')->find($request['empresa_area_id']);
            // return response()->json($rol);
            if (!$empresa_area) return response()->json(["Error:" => "El Empresa Area ingresado no existe"]);

            $empresa_personales = $request->empresa_personales;
            foreach ($empresa_personales as $empresa_personal) {
                // return response()->json($buscar);
                $empresa_per = EmpresaPersonal::where('estado_registro', 'A')->where('id', $empresa_personal['id'])->first();
                if (!$empresa_per) return response()->json(["error" => "Alguna Empresa Personal no existe"]);
                $empresa_per->fill([
                    "empresa_area_id" => $empresa_area->id,
                ])->save();
            }
            DB::commit();
            return response()->json(["resp" => "Empresa Areas asignadas correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "" . $e]);
        }
    }


    /**
     *  Muestra los personales de una empresa respeto a sus areas
     *  @OA\Get (
     *      path="/api/empresa/personal/area/get/{id_area}",
     *      summary="Muestra los personales de ua empresa respecto a sus areas de empresa",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Empresa-Personal"},
     *      @OA\Parameter(description="ID del area de la empresa",
     *          @OA\Schema(type="number"),name="empresa_area",in="path",required= true,example=3),
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
     *                      @OA\Property(property="nombre", type="string", example="Administrador Empresa"),
     *                      @OA\Property(property="bregma_id", type="integer", example=null),
     *                      @OA\Property(property="empresa_id", type="integer", example=2),
     *                      @OA\Property(property="clinica_id", type="integer", example=null),
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
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentalo de nuevo ..."),
     *          )
     *      ),
     *  )
     */
    public function get_personal_area(Request $request, $id_area)
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $personal_empresa = EmpresaPersonal::with(
                'rol',
                'user_rol.user',
                'persona',
                'empresa_area',
            )
                ->where('empresa_area_id', $id_area)
                ->Orwhere('empresa_area_id', null)
                ->get();
            return response()->json(["data" => $personal_empresa, "size" => count($personal_empresa)]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "" . $e]);
        }
    }
}
