<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ClinicaContacto;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bregma;
use App\Models\Celular;
use App\Models\Clinica;
use App\Models\Correo;
use App\Models\Persona;
use App\Models\UserRol;
use App\User;
use Exception;
use Faker\Provider\ar_JO\Person;
use Illuminate\Support\Facades\Validator;

class ClinicaContactoController extends Controller
{
    private $Persona;
    public function __construct(PersonaController $Persona)
    {
        $this->Persona = $Persona;
    }
    /**
     *  Crea un Contacto de una Clinica
     *  @OA\POST (
     *      path="/api/clinica/contacto/create/{clinica_id}",
     *      summary="Crea un contacto de clinica con sesión iniciada",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Clinica-Contacto"},
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
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Parameter(in="path",name="clinica_id",required=true,@OA\Schema(type="string")),
     *      @OA\Parameter(description="Id del tipo de documento",
     *          @OA\Schema(type="number"),name="tipo_documento_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Numero del documento",
     *          @OA\Schema(type="string"),name="numero_documento",in="query",required= false,example="07485459"
     *      ),
     *      @OA\Parameter(description="Nombres",
     *          @OA\Schema(type="string"),name="nombres",in="query",required= false,example="Frank"
     *      ),
     *      @OA\Parameter(description="Apellido paterno",
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required= false,example="Escovedo"
     *      ),
     *      @OA\Parameter(description="Apellido materno",
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required= false,example="SIMPSON"
     *      ),
     *      @OA\Parameter(description="Cargo del personal",
     *          @OA\Schema(type="string"),name="cargo",in="query",required= false,example="personal"
     *      ),
     *      @OA\Parameter(description="Fecha de nacimiento",
     *          @OA\Schema(type="string"),name="fecha_nacimiento",in="query",required= false,example="2002-02-06"
     *      ),
     *      @OA\Parameter(description="Hobbies del personal",
     *          @OA\Schema(type="string"),name="hobbies",in="query",required= false,example="futbol"
     *      ),
     *      @OA\Parameter(description="Número de celular",
     *          @OA\Schema(type="string"),name="celular",in="query",required= false,example="965214545"
     *      ),
     *      @OA\Parameter(description="Número de telefono",
     *          @OA\Schema(type="string"),name="telefono",in="query",required= false,example="2415410"
     *      ),
     *      @OA\Parameter(description="Correo electronico",
     *          @OA\Schema(type="string"),name="correo",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Direccion",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Número de telefono de emergencia",
     *          @OA\Schema(type="string"),name="telefono_emergencia",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Número de celular o telefono de contacto de emergencia",
     *          @OA\Schema(type="string"),name="contacto_emergencia",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del distrito",
     *          @OA\Schema(type="number"),name="distrito_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del distrito donde esta el domicilio",
     *          @OA\Schema(type="number"),name="distrito_domicilio_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID de estado civil",
     *          @OA\Schema(type="number"),name="estado_civil_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID de la religion",
     *          @OA\Schema(type="number"),name="religion_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del sexo o genero",
     *          @OA\Schema(type="number"),name="sexo_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del grado de instruccion",
     *          @OA\Schema(type="number"),name="grado_instruccion_id",in="query",required= false
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Clínica contacto creada"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No ingreso datos en al campo :attribute"),
     *          )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ya existe un contacto activo con el numero de documento"),
     *          )
     *      ),
     *  )
     */
    public function create(Request $request, $clinica_id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->find(auth()->user()->id);
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required'
            ];
            $persona_dup = Persona::where('numero_documento', $request->numero_documento)->first();
            if ($persona_dup) {
                $contacto  = ClinicaContacto::where('persona_id', $persona_dup->id)->where('estado_registro', 'A')->first();
                if ($contacto) return response()->json(["error" => "Ya existe un contacto activo con el numero de documento"], 500);
            }
            $persona = $this->Persona->store($request);
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            $clinicaContacto = ClinicaContacto::updateOrCreate([
                "persona_id" => $persona->id,
                "clinica_id" => $clinica_id
            ], [
                'estado_registro' => 'A'
            ]);
            DB::commit();
            return response()->json(["resp" => "Clínica contacto creada"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error al crear " . $e]);
        }
    }
    /**
     *  Actualiza un Contacto de una Clinica
     *  @OA\PUT (
     *      path="/api/clinica/contacto/update/{contacto_id}/{clinica_id}",
     *      summary="Actualiza un contacto de clinica con sesión iniciada",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Clinica-Contacto"},
     *      @OA\Parameter(in="path",name="contacto_id",required=true,@OA\Schema(type="string")),
     *      @OA\Parameter(in="path",name="clinica_id",required=true,@OA\Schema(type="string")),
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
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Parameter(description="Id del contacto de clinica",
     *          @OA\Schema(type="number"),name="contacto_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Id de la clinica",
     *          @OA\Schema(type="number"),name="clinica_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Id del tipo de documento",
     *          @OA\Schema(type="number"),name="tipo_documento_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Numero del documento",
     *          @OA\Schema(type="string"),name="numero_documento",in="query",required= false,example="07485459"
     *      ),
     *      @OA\Parameter(description="Nombres",
     *          @OA\Schema(type="string"),name="nombres",in="query",required= false,example="Frank"
     *      ),
     *      @OA\Parameter(description="Apellido paterno",
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required= false,example="Escovedo"
     *      ),
     *      @OA\Parameter(description="Apellido materno",
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required= false,example="SIMPSON"
     *      ),
     *      @OA\Parameter(description="Cargo del personal",
     *          @OA\Schema(type="string"),name="cargo",in="query",required= false,example="personal"
     *      ),
     *      @OA\Parameter(description="Fecha de nacimiento",
     *          @OA\Schema(type="string"),name="fecha_nacimiento",in="query",required= false,example="2002-02-06"
     *      ),
     *      @OA\Parameter(description="Hobbies del personal",
     *          @OA\Schema(type="string"),name="hobbies",in="query",required= false,example="futbol"
     *      ),
     *      @OA\Parameter(description="Número de celular",
     *          @OA\Schema(type="string"),name="celular",in="query",required= false,example="965214545"
     *      ),
     *      @OA\Parameter(description="Número de telefono",
     *          @OA\Schema(type="string"),name="telefono",in="query",required= false,example="2415410"
     *      ),
     *      @OA\Parameter(description="Correo electronico",
     *          @OA\Schema(type="string"),name="correo",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Direccion",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Número de telefono de emergencia",
     *          @OA\Schema(type="string"),name="telefono_emergencia",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Número de celular o telefono de contacto de emergencia",
     *          @OA\Schema(type="string"),name="contacto_emergencia",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del distrito",
     *          @OA\Schema(type="number"),name="distrito_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del distrito donde esta el domicilio",
     *          @OA\Schema(type="number"),name="distrito_domicilio_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID de estado civil",
     *          @OA\Schema(type="number"),name="estado_civil_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID de la religion",
     *          @OA\Schema(type="number"),name="religion_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del sexo o genero",
     *          @OA\Schema(type="number"),name="sexo_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="ID del grado de instruccion",
     *          @OA\Schema(type="number"),name="grado_instruccion_id",in="query",required= false
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Clínica contacto actualizada"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No ingreso datos en al campo :attribute"),
     *          )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No existe un contacto con ese id"),
     *          )
     *      ),
     *      @OA\Response(response=501, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ya existe un contacto activo con el numero de documento"),
     *          )
     *      ),
     *  )
     */

    public function update(Request $request, $contacto_id, $clinica_id)
    {
        DB::beginTransaction();
        try {
            $contacto = ClinicaContacto::where('estado_registro', 'A')->find($contacto_id);
            if (!$contacto) return response()->json(['error' => 'No existe un contacto con el id'], 500);
            $reglas = [
                'tipo_documento_id' => 'required',
                'numero_documento' => 'required'
            ];
            $persona_dup = Persona::where('numero_documento', $request->numero_documento)->where('id', '!=', $contacto->persona_id)->first();
            
            if ($persona_dup) {
            $contacto_dup  = ClinicaContacto::where('persona_id', $persona_dup->id)->where('estado_registro', 'A')->first();
            if(!$contacto_dup) return response()->json(["error" => "La persona no existe o esta inactivada"], 501);
            if ($contacto_dup) return response()->json(["error" => "Ya existe un contacto activo con el numero de documento"], 501);
            }
            $persona = $this->Persona->update($request, $contacto->persona_id);
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            
            $contacto->fill([
                "persona_id" => $persona->id,
                "clinica_id" => $clinica_id,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Clínica contacto actualizado"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error al crear " . $e]);
        }
    }
    /**
     * Elimina un Contacto de Clinica
     * @OA\DELETE (
     *     path="/api/clinica/contacto/delete/{idClinicaContacto}",
     *     summary="Elimina un clinica contacto con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica-Contacto"},
     *      @OA\Parameter(
     *          description="idClinicaContacto",
     *          @OA\Schema(type="number"),
     *          name="idClinicaContacto",
     *          in="path",
     *          required= true,
     *          example=1
     *      ),
     *      @OA\Response(response = 200, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Clínica Contacto eliminado"),
     *          )
     *      ),
     *      @OA\Response(response = 400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Id de clínica contacto no existe."),
     *          )
     *      ),
     *      @OA\Response(response = 401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al eliminar clínica contacto"),
     *          )
     *      ),
     * )
     */

    public function delete($contacto_id)
    {
        DB::beginTransaction();
        try {
            $contacto = ClinicaContacto::find($contacto_id);
            $celular = Celular::where('persona_id', $contacto->persona_id)->first();
            $correo = Correo::where('persona_id', $contacto->persona_id)->first();

            if ($contacto) {

                $contacto->fill([
                    "estado_registro" => "I",
                ])->save();

                $celular->fill([
                    'estado_registro' => "I"
                ])->save();

                $correo->fill([
                    'estado_registro' => "I"
                ])->save();

                DB::commit();
                return response()->json(["resp" => "Clínica Contacto eliminado"]);
            } else {
                return response()->json(["error" => "No existe un contacto con el id"], 500);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error ", "Error al eliminar clínica contacto" . "" => $e]);
        }
    }

    /**
     *  Mostrar contacto en especifico
     *  @OA\GET (
     *      path="/api/clinica/contacto/show/{contacto_id}",
     *      summary="Mostrar contacto en especifico",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Clinica-Contacto"},
     *      @OA\Parameter(in="path",name="contacto_id",required=true,@OA\Schema(type="string")),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="object", property="data",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="persona_id", type="number", example=4),
     *                  @OA\Property(property="clinica_id", type="number", example=2),
     *                  @OA\Property(property="estado_registro", type="string", example="A"),
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
     *              @OA\Property(property="resp", type="string", example="Id del usuario erróneo o no existe"),
     *          )
     *      ),
     *      @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     *  )
     */
    public function show($contacto_id)
    {
        try {
            $contacto = ClinicaContacto::with(
                'persona.tipo_documento',
                'persona.distrito.provincia.departamento',
                'persona.distrito_domicilio',
                'persona.estado_civil',
                'persona.religion',
                'persona.sexo',
                'persona.grado_instruccion'
            )->where('estado_registro','A')->find($contacto_id);
            if ($contacto) {
                return response()->json(["data" => $contacto]);
            } else {
                return response()->json(["error" => "No existe un contacto con ese id"]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error", "" => $e]);
        }
    }
    /**
     *  Mostrar todos los registros de contacto clinica
     *  @OA\GET (
     *      path="/api/clinica/contacto/get",
     *      summary="Mostrar todos los registros de contacto clinica",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Clinica-Contacto"},
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="persona_id", type="number", example=4),
     *                      @OA\Property(property="clinica_id", type="number", example=2),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
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
     *      @OA\Response(response=500,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen registros"),
     *          )
     *      ),
     *  )
     */
    public function get()
    {
        try {
            $contacto = ClinicaContacto::with(
                'persona.tipo_documento',
                'persona.distrito.provincia.departamento',
                'persona.distrito_domicilio',
                'persona.estado_civil',
                'persona.religion',
                'persona.sexo',
                'persona.grado_instruccion'
            )->where('estado_registro','A')->get();
            if (count($contacto)==0)return response()->json(["resp"=>"No existen registros"],500);
            return response()->json(["data"=>$contacto,"size"=>count($contacto)]);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error", "" => $e]);
        }
    }
}
