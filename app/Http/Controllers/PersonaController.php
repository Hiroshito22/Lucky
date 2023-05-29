<?php

namespace App\Http\Controllers;

use App\Models\BregmaPersonal;
use App\Models\Celular;
use App\Models\CelularInstitucion;
use App\Models\ClinicaContacto;
use App\Models\ClinicaPersonal;
use App\Models\Correo;
use App\Models\CorreoInstitucion;
use App\Models\Detraccion;
use App\Models\EmpresaContacto;
use App\Models\EmpresaPersonal;
use App\Models\EntidadPago;
use App\Models\HistoriaClinica;
use App\Models\Paciente;
use App\Models\Persona;
use App\Models\PersonaEntidadPago;
use App\Models\Personal;
use App\Models\UserRol;
use App\User;
use Exception;
use Illuminate\Cache\NullStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class PersonaController extends Controller
{
    /**
     *  Crear persona
     *  @OA\Post (
     *      path="/api/persona/create",
     *      summary="Crear una nueva persona",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Personas"},
     *      @OA\Parameter(description="Numero de documento",
     *          @OA\Schema(type="string"), name="numero_documento",in="query",required=false,example="11111111"),
     *      @OA\Parameter(description="ID del tipo de documento",
     *          @OA\Schema(type="number"),name="tipo_documento_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="Nombres",
     *          @OA\Schema(type="string"),name="nombres",in="query",required=false,example="Jose"),
     *      @OA\Parameter(description="Apellido paterno",
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required=false,example="Haraos"),
     *      @OA\Parameter(description="Apellido materno",
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required=false,example="Haraos"),
     *      @OA\Parameter(description="Fecha de nacimiento",
     *          @OA\Schema(type="string"),name="fecha_nacimiento",in="query",required=false,example="2019-01-01"),
     *      @OA\Parameter(description="Numero de celular",
     *          @OA\Schema(type="number"),name="celular",in="query",required=false,example=100200300),
     *      @OA\Parameter(description="Numero de telefono valido",
     *          @OA\Schema(type="string"),name="telefono",in="query",required=false,example="01-222"),
     *      @OA\Parameter(description="Correo electrónico",
     *          @OA\Schema(type="string"),name="correo",in="query",required=false,example="riquelme@gmail.com"),
     *      @OA\Parameter(description="Dirección",
     *          @OA\Schema(type="string"),name="direccion",in="query",required=false,example="Av. José"),
     *      @OA\Parameter(description="Numero Telefono de emergencia",
     *          @OA\Schema(type="string"),name="telefono_emergencia",in="query",required=false,example="01-22233"),
     *      @OA\Parameter(description="Contacto de emergencia",
     *          @OA\Schema(type="string"),name="contacto_emergencia",in="query",required=false,example="999666333"),
     *      @OA\Parameter(description="ID de distrito",
     *          @OA\Schema(type="number"),name="distrito_id",in="query",required=false,example=12),
     *      @OA\Parameter(description="ID del distrito de su domicilio",
     *          @OA\Schema(type="number"),name="distrito_domicilio_id",in="query",required=false,example=10),
     *      @OA\Parameter(description="ID de su estado civil",
     *          @OA\Schema(type="number"),name="estado_civil_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="ID de religion a la que pertenece",
     *          @OA\Schema(type="number"),name="religion_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="ID de su sexo",
     *          @OA\Schema(type="number"),name="sexo_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="ID del grado de instrucción que tiene",
     *          @OA\Schema(type="number"),name="grado_instruccion_id",in="query",required=false,example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object",
     *                  @OA\Property(description="Subir foto de perfil",property="foto",type="file"),
     *                  @OA\Property(property="tipo_documento_id",type="foreignId"),
     *                  @OA\Property(property="numero_documento",type="string"),
     *                  @OA\Property(property="nombres",type="string"),
     *                  @OA\Property(property="apellido_paterno",type="string"),
     *                  @OA\Property(property="apellido_materno", type="string"),
     *                  @OA\Property(property="cargo", type="string"),
     *                  @OA\Property(property="fecha_nacimiento", type="string"),
     *                  @OA\Property(property="hobbies", type="string"),
     *                  @OA\Property(property="celular",type="string"),
     *                  @OA\Property(property="telefono",type="string"),
     *                  @OA\Property(property="correo",type="string"),
     *                  @OA\Property(property="direccion",type="string"),
     *                  @OA\Property(property="telefono_emergencia",type="string"),
     *                  @OA\Property(property="contacto_emergencia",type="string"),
     *                  @OA\Property(property="rol_id",type="foreignId"),
     *                  @OA\Property(property="usuario",type="string"),
     *                  @OA\Property(property="distrito_id",type="foreignId"),
     *                  @OA\Property(property="distrito_domicilio_id",type="foreignId"),
     *                  @OA\Property(property="estado_civil_id",type="foreignId"),
     *                  @OA\Property(property="religion_id",type="foreignId"),
     *                  @OA\Property(property="sexo_id",type="foreignId"),
     *                  @OA\Property(property="grado_instruccion_id",type="foreignId")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number",example=1),
     *              @OA\Property(property="numero_documento", type="string",example="11111111"),
     *              @OA\Property(property="nombres", type="string", example="Jose"),
     *              @OA\Property(property="apellido_paterno", type="string",example="Vasquez"),
     *              @OA\Property(property="apellido_materno", type="string", example="Perez"),
     *              @OA\Property( property="fecha_nacimiento", type="date", example="2002/04/12"),
     *              @OA\Property(property="celular", type="number", example=12341234),
     *              @OA\Property(property="telefono", type="string", example="29874511"),
     *              @OA\Property(property="email", type="string", example="ruka@gmail.com"),
     *              @OA\Property(property="direccion", type="string", example="Av cantogrande 258"),
     *              @OA\Property(property="telefono_emergencia", type="string", example="6524157"),
     *              @OA\Property(property="contacto_emergencia", type="string", example="96301245"),
     *              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *              @OA\Property(property="distrito_id", type="number", example=1),
     *              @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *              @OA\Property(property="estado_civil_id", type="number", example=1),
     *              @OA\Property(property="religion_id", type="number", example=1),
     *              @OA\Property(property="sexo_id", type="number", example=1),
     *              @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *              @OA\Property(type="object",property="tipo_documento",
     *                  @OA\Property(property="id",type="number",example=1),
     *                      @OA\Property(property="nombre",type="string",example="DNI"),
     *                      @OA\Property(property="codigo",type="string",example=""),
     *                      @OA\Property(property="descripcion",type="string",example="Documenta nacional de identidad"),
     *                      @OA\Property(property="estado_registro",type="string",example="A"),
     *                  )
     *              )
     *          )
     *      )
     *  )
     *
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            //return response()->json(["resp" => "Persona creada exitosamente"]);
            $persona = Persona::updateOrCreate([
                'numero_documento' => $request->numero_documento,
                'tipo_documento_id' => $request->tipo_documento_id
            ], [
                'nombres' => $request->nombres,
                'apellido_paterno' => $request->apellido_paterno === "null" ? null : $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno === "null" ? null : $request->apellido_materno,
                'cargo' => $request->cargo === "null" ? null : $request->cargo,
                'fecha_nacimiento' => $request->fecha_nacimiento === "null" ? null : $request->fecha_nacimiento,
                'hobbies' => $request->hobbies === "null" ? null : $request->hobbies,
                'celular' => $request->celular === "null" ? null : $request->celular,
                'telefono' => $request->telefono === "null" ? null : $request->telefono,
                'correo' => $request->email === "null" ? null : $request->correo,
                'direccion' => $request->direccion === "null" ? null : $request->direccion,
                'telefono_emergencia' => $request->telefono_emergencia === "null" ? null : $request->telefono_emergencia,
                'contacto_emergencia' => $request->contacto_emergencia === "null" ? null : $request->contacto_emergencia,
                'distrito_id' => $request->distrito_id === "null" ? null : $request->distrito_id,
                'distrito_domicilio_id' => $request->distrito_domicilio_id === "null" ? null : $request->distrito_domicilio_id,
                'estado_civil_id' => $request->estado_civil_id === "null" ? null : $request->estado_civil_id,
                'religion_id' => $request->religion_id === "null" ? null : $request->religion_id,
                'sexo_id' => $request->sexo_id === "null" ? null : $request->sexo_id,
                'grado_instruccion_id' => $request->grado_instruccion_id === "null" ? null : $request->grado_instruccion_id,
            ]);
            if ($request->hasFile('foto')) {
                $path = $request->foto->storeAs('public/personas', $persona->id . '.' . $request->foto->extension());
                $image = $persona->id . '.' . $request->foto->extension();
                //$image = $path;
            } else {
                $image = null;
            }
            $persona->foto = $image;
            $persona->save();
            Celular::updateOrCreate([
                "persona_id" => $persona->id,
            ], [
                "celular" => $request->celular === "null" ? null : $request->celular,
            ]);

            Correo::updateOrCreate([
                "persona_id" => $persona->id,
            ], [
                "correo" => $request->correo === "null" ? null : $request->correo,
            ]);
            DB::commit();
            return $persona;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
    
    public function store_institucion(Request $request, $bregma_id, $clinica_id, $empresa_id)
    {
        DB::beginTransaction();
        try {
            //return response()->json(["resp" => "Persona creada exitosamente"]);
            $persona = Persona::updateOrCreate([
                'numero_documento' => $request->numero_documento,
                'tipo_documento_id' => 2
            ], [
                'nombres' => $request->razon_social,
                'celular' => $request->celular === "null" ? null : $request->celular,
                'telefono' => $request->telefono === "null" ? null : $request->telefono,
                'correo' => $request->email === "null" ? null : $request->correo,
                'direccion' => $request->direccion === "null" ? null : $request->direccion,
                'distrito_id' => $request->distrito_id === "null" ? null : $request->distrito_id,
                'distrito_domicilio_id' => $request->distrito_domicilio_id === "null" ? null : $request->distrito_domicilio_id,
            ]);
            if ($request->hasFile('foto')) {
                $path = $request->foto->storeAs('public/personas', $persona->id . '.' . $request->foto->extension());
                $image = $persona->id . '.' . $request->foto->extension();
                //$image = $path;
            } else {
                $image = null;
            }
            $persona->foto = $image;
            $persona->save();
            $celular = CelularInstitucion::updateOrCreate([
                'celular' => $request->celular,
                'persona_id' => $persona->id
            ], [
                'bregma_id' => $bregma_id,
                'clinica_id' => $clinica_id,
                'empresa_id' => $empresa_id
            ]);
            $correo = CorreoInstitucion::updateOrCreate([
                'correo' => $request->correo,
                'persona_id' => $persona->id
            ], [
                'bregma_id' => $bregma_id,
                'clinica_id' => $clinica_id,
                'empresa_id' => $empresa_id
            ]);
            DB::commit();
            return $persona;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "error", "error" => $e]);
        }
    }

    /**
     *  Actualizar persona
     *  @OA\Put (
     *      path="/api/persona/update/{id}",
     *      summary="Actualizar una persona",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Personas"},
     *      @OA\Parameter(description="ID de la persona",
     *          @OA\Schema(type="number"), name="id",in="path",required=true,example=1),
     *      @OA\Parameter(description="Numero de documento",
     *          @OA\Schema(type="string"), name="numero_documento",in="query",required=false,example="11111111"),
     *      @OA\Parameter(description="ID del tipo de documento",
     *          @OA\Schema(type="number"),name="tipo_documento_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="Nombres",
     *          @OA\Schema(type="string"),name="nombres",in="query",required=false,example="Jose"),
     *      @OA\Parameter(description="Apellido paterno",
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required=false,example="Haraos"),
     *      @OA\Parameter(description="Apellido materno",
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required=false,example="Haraos"),
     *      @OA\Parameter(description="Fecha de nacimiento",
     *          @OA\Schema(type="string"),name="fecha_nacimiento",in="query",required=false,example="2019-01-01"),
     *      @OA\Parameter(description="Numero de celular",
     *          @OA\Schema(type="number"),name="celular",in="query",required=false,example=100200300),
     *      @OA\Parameter(description="Numero de telefono valido",
     *          @OA\Schema(type="string"),name="telefono",in="query",required=false,example="01-222"),
     *      @OA\Parameter(description="Correo electrónico",
     *          @OA\Schema(type="string"),name="correo",in="query",required=false,example="riquelme@gmail.com"),
     *      @OA\Parameter(description="Dirección",
     *          @OA\Schema(type="string"),name="direccion",in="query",required=false,example="Av. José"),
     *      @OA\Parameter(description="Numero Telefono de emergencia",
     *          @OA\Schema(type="string"),name="telefono_emergencia",in="query",required=false,example="01-22233"),
     *      @OA\Parameter(description="Contacto de emergencia",
     *          @OA\Schema(type="string"),name="contacto_emergencia",in="query",required=false,example="999666333"),
     *      @OA\Parameter(description="ID de distrito",
     *          @OA\Schema(type="number"),name="distrito_id",in="query",required=false,example=12),
     *      @OA\Parameter(description="ID del distrito de su domicilio",
     *          @OA\Schema(type="number"),name="distrito_domicilio_id",in="query",required=false,example=10),
     *      @OA\Parameter(description="ID de su estado civil",
     *          @OA\Schema(type="number"),name="estado_civil_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="ID de religion a la que pertenece",
     *          @OA\Schema(type="number"),name="religion_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="ID de su sexo",
     *          @OA\Schema(type="number"),name="sexo_id",in="query",required=false,example=1),
     *      @OA\Parameter(description="ID del grado de instrucción que tiene",
     *          @OA\Schema(type="number"),name="grado_instruccion_id",in="query",required=false,example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object",
     *                  @OA\Property(description="Subir foto de perfil",property="foto",type="file"),
     *                  @OA\Property(property="tipo_documento_id",type="foreignId"),
     *                  @OA\Property(property="numero_documento",type="string"),
     *                  @OA\Property(property="nombres",type="string"),
     *                  @OA\Property(property="apellido_paterno",type="string"),
     *                  @OA\Property(property="apellido_materno", type="string"),
     *                  @OA\Property(property="cargo", type="string"),
     *                  @OA\Property(property="fecha_nacimiento", type="string"),
     *                  @OA\Property(property="hobbies", type="string"),
     *                  @OA\Property(property="celular",type="string"),
     *                  @OA\Property(property="telefono",type="string"),
     *                  @OA\Property(property="correo",type="string"),
     *                  @OA\Property(property="direccion",type="string"),
     *                  @OA\Property(property="telefono_emergencia",type="string"),
     *                  @OA\Property(property="contacto_emergencia",type="string"),
     *                  @OA\Property(property="rol_id",type="foreignId"),
     *                  @OA\Property(property="usuario",type="string"),
     *                  @OA\Property(property="distrito_id",type="foreignId"),
     *                  @OA\Property(property="distrito_domicilio_id",type="foreignId"),
     *                  @OA\Property(property="estado_civil_id",type="foreignId"),
     *                  @OA\Property(property="religion_id",type="foreignId"),
     *                  @OA\Property(property="sexo_id",type="foreignId"),
     *                  @OA\Property(property="grado_instruccion_id",type="foreignId")    
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number",example=1),
     *              @OA\Property(property="numero_documento", type="string",example="11111111"),
     *              @OA\Property(property="nombres", type="string", example="Jose"),
     *              @OA\Property(property="apellido_paterno", type="string",example="Vasquez"),
     *              @OA\Property(property="apellido_materno", type="string", example="Perez"),
     *              @OA\Property( property="fecha_nacimiento", type="date", example="2002/04/12"),
     *              @OA\Property(property="celular", type="number", example=12341234),
     *              @OA\Property(property="telefono", type="string", example="29874511"),
     *              @OA\Property(property="email", type="string", example="ruka@gmail.com"),
     *              @OA\Property(property="direccion", type="string", example="Av cantogrande 258"),
     *              @OA\Property(property="telefono_emergencia", type="string", example="6524157"),
     *              @OA\Property(property="contacto_emergencia", type="string", example="96301245"),
     *              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *              @OA\Property(property="distrito_id", type="number", example=1),
     *              @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *              @OA\Property(property="estado_civil_id", type="number", example=1),
     *              @OA\Property(property="religion_id", type="number", example=1),
     *              @OA\Property(property="sexo_id", type="number", example=1),
     *              @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *              @OA\Property(type="object",property="tipo_documento",
     *                  @OA\Property(property="id",type="number",example=1),
     *                      @OA\Property(property="nombre",type="string",example="DNI"),
     *                      @OA\Property(property="codigo",type="string",example=""),
     *                      @OA\Property(property="descripcion",type="string",example="Documenta nacional de identidad"),
     *                      @OA\Property(property="estado_registro",type="string",example="A"),
     *                  )
     *              )
     *          )
     *      )
     *  )
     *
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $persona = Persona::find($id);
            if (!$persona) return response()->json(["error" => "No hay una persona con el id"]);
            $duplicado_numero_documento = Persona::where('numero_documento',$request->numero_documento)->where('id','!=',$id)->first();
            if ($duplicado_numero_documento) response()->json(["error"=>"Ya existe otra persona con ese numero de documento"]);
            $persona->fill([
                "numero_documento" => $request->numero_documento === "null" ? null : $request->numero_documento,
                "nombres" => $request->nombres === "null" ? null : $request->nombres,
                "apellido_paterno" => $request->apellido_paterno === "null" ? null : $request->apellido_paterno,
                "apellido_materno" => $request->apellido_materno === "null" ? null : $request->apellido_materno,
                "cargo" => $request->cargo === "null" ? null : $request->cargo,
                "fecha_nacimiento" => $request->fecha_nacimiento,
                "hobbies" => $request->hobbies === "null" ? null : $request->hobbies,
                "celular" => $request->celular === "null" ? null : $request->celular,
                "telefono" => $request->telefono === "null" ? null : $request->telefono,
                "correo" => $request->correo === "null" ? null : $request->correo,
                "direccion" => $request->direccion === "null" ? null : $request->direccion,
                "tipo_documento_id" => $request->tipo_documento_id === "null" ? null : $request->tipo_documento_id,
                "distrito_id" => $request->distrito_id === "null" ? null : $request->distrito_id,
                "distrito_domicilio_id" => $request->distrito_domicilio_id === "null" ? null : $request->distrito_domicilio_id,
                "estado_civil_id" => $request->estado_civil_id === "null" ? null : $request->estado_civil_id,
                "religion_id" => $request->religion_id === "null" ? null : $request->religion_id,
                "sexo_id" => $request->sexo_id === "null" ? null : $request->sexo_id,
                "grado_instruccion_id" => $request->grado_instruccion_id === "null" ? null : $request->grado_instruccion_id
            ])->save();
            Celular::updateOrCreate([
                "persona_id" => $persona->id,
            ], [
                "celular" => $request->celular === "null" ? null : $request->celular,
            ]);

            Correo::updateOrCreate([
                "persona_id" => $persona->id,
            ], [
                "correo" => $request->correo === "null" ? null : $request->correo,
            ]);

            if ($request->hasFile('foto')) {
                Storage::delete('personas/' . $persona->getRawOriginal('foto'));
                $image = $persona->id . now()->format('Ymd_hms') . '.' . $request->foto->extension();
                $request->file('foto')->storeAs('personas/', $image);
                $persona->foto = $image;
                $persona->save();
            }
            DB::commit();
            return $persona;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "" . $e]);
        }
    }

    /**
     * Eliminar persona
     * @OA\Delete (
     *     path="/api/personas/delete/{idpersona}",
     *     summary="Eliminar a la persona registrada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Personas"},
     *     @OA\Parameter(
     *        description="ID de la persona registrada",
     *        @OA\Schema(type="number"),
     *        name="idpersona",
     *        in="path",
     *        required=true,
     *        example=2
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Persona eliminada correctamente"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Registro persona no encontrado"),
     *          )
     *      )
     * )
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $personaDelete = Persona::find($id);
            if ($personaDelete) {
                $personaDelete->delete();
                DB::commit();
                return response()->json(["resp" => "Persona eliminada correctamente"]);
            } else {
                return response()->json(["resp" => "Registro no encontrado"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            if (!$user) return response()->json(["error" => "No existe ningun usuario"]);
            $empresa = Persona::find($id);
            if (!$empresa) return response()->json(["error" => "No existe la empresa"]);
            $empresa->fill([
                "tipo_documento_id" => null,
                "distrito_id" => null,
                "rubro_id" => null,
            ]);
            PersonaEntidadPago::where('persona_id',$id)->update(["persona_id" => null]);
            Detraccion::where('persona_id',$id)->update(["persona_id" => null]);
            CelularInstitucion::where('persona_id',$id)->update(["persona_id" => null]);
            CorreoInstitucion::where('persona_id',$id)->update(["persona_id" => null]);
            ClinicaPersonal::where('persona_id',$id)->update(["persona_id" => null]);
            Paciente::where('persona_id',$id)->update(["persona_id" => null]);
            EmpresaPersonal::where('persona_id',$id)->update(["persona_id" => null]);
            HistoriaClinica::where('persona_id',$id)->update(["persona_id" => null]);
            Personal::where('persona_id',$id)->update(["persona_id" => null]);
            User::where('persona_id',$id)->update(["persona_id" => null]);
            ClinicaContacto::where('persona_id',$id)->update(["persona_id" => null]);
            EntidadPago::where('persona_id',$id)->update(["persona_id" => null]);
            BregmaPersonal::where('persona_id',$id)->update(["persona_id" => null]);
            Celular::where('persona_id',$id)->update(["persona_id" => null]);
            Correo::where('persona_id',$id)->update(["persona_id" => null]);
            EmpresaPersonal::where('persona_id',$id)->update(["persona_id" => null]);
            EmpresaContacto::where('persona_id',$id)->update(["persona_id" => null]);
            PersonaEntidadPago::where('persona_id',$id)->update(["persona_id" => null]);
            $empresa->save();
            $empresa->delete();
            return response()->json(["Personal Eliminado exitosamente"]);
            //return response()->json($celular_institucion);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Obtener a la persona registrada.
     *  @OA\Get(
     *      path="/api/personas/show/{idpersona}",
     *      summary="Obtener a la persona registrada",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Personas"},
     *      @OA\Parameter(description="ID de la persona registrada",
     *          @OA\Schema(type="number"), name="idpersona",in="path",required=true,example=2
     *      ),
     *      @OA\response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=2),
     *              @OA\Property(property="numero_documento", type="string",example="11111111"),
     *              @OA\Property(property="nombres", type="string", example="Jose"),
     *              @OA\Property(property="apellido_paterno", type="string",example=""),
     *              @OA\Property(property="apellido_materno", type="string", example=""),
     *              @OA\Property(property="fecha_nacimiento", type="date", example=""),
     *              @OA\Property(property="celular", type="number", example=12341234),
     *              @OA\Property(property="telefono", type="string", example=""),
     *              @OA\Property(property="email", type="string", example="ruka@gmail.com"),
     *              @OA\Property(property="direccion", type="string", example=""),
     *              @OA\Property(property="telefono_emergencia", type="string", example=""),
     *              @OA\Property(property="contacto_emergencia", type="string", example=""),
     *              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *              @OA\Property(property="distrito_id", type="number", example=1),
     *              @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *              @OA\Property(property="estado_civil_id", type="number", example=1),
     *              @OA\Property(property="religion_id", type="number", example=1),
     *              @OA\Property(property="sexo_id", type="number", example=1),
     *              @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *              @OA\Property(type="object",property="tipo_documento",
     *                  @OA\Property(property="id",type="number",example=1),
     *                  @OA\Property(property="nombre",type="string",example="DNI"),
     *                  @OA\Property(property="codigo",type="string",example=""),
     *                  @OA\Property(property="descripcion",type="string",example="Documenta nacional de identidad"),
     *                  @OA\Property(property="estado_registro",type="string",example="A"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Persona no encontrada"),
     *          )
     *      )
     *  )
     */
    public function show($id)
    {
        try {
            $persona = Persona::with(["tipo_documento"])->find($id);
            //return response()->json($persona);
            if ($persona) {
                return response()->json($persona);
            } else {
                return response()->json(["resp" => "Persona no encontrada"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Obtener a la persona registrada.
     * @OA\Get(
     *   path="/api/persona/show",
     *   summary="Obtener a la persona registrada",
     *   security={{ "bearerAuth": {} }},
     *   tags={"Personas"},
     *    @OA\response(
     *       response=200,
     *       description="success",
     *       @OA\JsonContent(
     *          @OA\Property(property="id", type="number", example=2),
     *          @OA\Property(property="numero_documento", type="string",example="11111111"),
     *          @OA\Property(property="nombres", type="string", example="Jose"),
     *          @OA\Property(property="apellido_paterno", type="string",example=""),
     *          @OA\Property(property="apellido_materno", type="string", example=""),
     *          @OA\Property( property="fecha_nacimiento", type="date", example=""),
     *          @OA\Property(property="celular", type="number", example=12341234),
     *          @OA\Property(property="telefono", type="string", example=""),
     *          @OA\Property(property="email", type="string", example="ruka@gmail.com"),
     *          @OA\Property(property="direccion", type="string", example=""),
     *          @OA\Property(property="telefono_emergencia", type="string", example=""),
     *          @OA\Property(property="contacto_emergencia", type="string", example=""),
     *          @OA\Property(property="tipo_documento_id", type="number", example=1),
     *          @OA\Property(property="distrito_id", type="number", example=1),
     *          @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *          @OA\Property(property="estado_civil_id", type="number", example=1),
     *          @OA\Property(property="religion_id", type="number", example=1),
     *          @OA\Property(property="sexo_id", type="number", example=1),
     *          @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *          @OA\Property(
     *              type="array",
     *              property="tipo_documento",
     *              @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="number",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string",
     *                     example="DNI"
     *                 ),
     *                 @OA\Property(
     *                     property="codigo",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="descripcion",
     *                     type="string",
     *                     example="Documenta nacional de identidad"
     *                 ),
     *                 @OA\Property(
     *                     property="estado_registro",
     *                     type="string",
     *                     example="A"
     *                 ),
     *             )
     *          ),
     *       )
     *    ),
     *    @OA\Response(
     *        response=400,
     *        description="invalid",
     *        @OA\JsonContent(
     *            @OA\Property(property="resp", type="string", example="Persona no encontrada"),
     *        )
     *    )
     * )
     */
    public function getShow()
    {
        try {
            $user = User::with(('persona.tipo_documento'))->where('id', auth()->user()->id)->first();
            return response()->json(["data" => $user]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Actualizar foto de persona.
     * @OA\Post(
     *    path="/api/personas/actualizarFoto/{idpersona}",
     *    summary="Actualizar foto de persona",
     *    security={{ "bearerAuth": {} }},
     *    tags={"Personas"},
     *    @OA\Parameter(
     *        description="ID de la persona registrada",
     *        @OA\Schema(type="number"),
     *        name="idpersona",
     *        in="path",
     *        required=true,
     *        example=2
     *      ),
     *    @OA\RequestBody(
     *       @OA\MediaType(
     *         mediaType="multipart/form-data",
     *         @OA\Schema(
     *            type="object",
     *            @OA\Property(
     *              description="Foto de perfil",
     *              property="foto",
     *              type="file"
     *            )
     *         )
     *       )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="success",
     *        @OA\JsonContent(
     *        @OA\Property(property="resp", type="string", example="foto actualizada correctamente"),
     *        )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *         @OA\Property(property="resp", type="string", example="Error al actualizar foto"),
     *         )
     *      )
     * )
     */
    public function actualizarFoto(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $persona = Persona::where('id', $id)->first();
            if ($request->hasFile('foto')) {
                Storage::delete('public/personas/' . $persona->getRawOriginal('foto'));
                $image = $persona->id . now()->format('Ymd_hms') . '.' . $request->foto->extension();
                $request->file('foto')->storeAs('public/personas/', $image);
                $persona->foto = $image;
                $persona->save();
                DB::commit();
                return response()->json(["resp" => "Foto actualizado", 'code' => $persona]);
            } else {
                return response()->json(["resp" => "Error al actualizar foto", 'code' => $persona]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "Foto no enviada.", "error" => $e]);
        }
    }

    /**
     *  Buscar persona por el numero de documento.
     *  @OA\Get(
     *      path="/api/persona/find/{num_documento}",
     *      summary="Buscar persona por el numero de documento",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Personas"},
     *      @OA\Parameter(description="Número de documento de la persona",
     *          @OA\Schema(type="string"),name="num_documento",in="path",required=true,example="21454125"
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="object", property="data",
     *                  @OA\Property(property="id", type="number", example=5),
     *                  @OA\Property(property="foto", type="file", example=null),
     *                  @OA\Property(property="numero_documento", type="string", example="48569512"),
     *                  @OA\Property(property="nombres", type="string", example="Bernardo"),
     *                  @OA\Property(property="apellido_paterno", type="string", example="Vaca"),
     *                  @OA\Property(property="apellido_materno", type="string", example="zeta"),
     *                  @OA\Property(property="cargo", type="string", example="personal"),
     *                  @OA\Property(property="fecha_nacimiento", type="string", example="2002-04-27"),
     *                  @OA\Property(property="hobbies", type="string", example="futbol"),
     *                  @OA\Property(property="celular", type="string", example="954784545"),
     *                  @OA\Property(property="telefono", type="string", example="2879410"),
     *                  @OA\Property(property="correo", type="string", example="email_prueba@gmail.com"),
     *                  @OA\Property(property="direccion", type="string", example="Av. las fresias 328"),
     *                  @OA\Property(property="telefono_emergencia", type="string", example="2648451"),
     *                  @OA\Property(property="contacto_emergencia", type="string", example="954241548"),
     *                  @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                  @OA\Property(property="distrito_id", type="number", example=1),
     *                  @OA\Property(property="distrito_domicilio_id", type="number", example=1),
     *                  @OA\Property(property="estado_civil_id", type="number", example=1),
     *                  @OA\Property(property="religion_id", type="number", example=1),
     *                  @OA\Property(property="sexo_id", type="number", example=1),
     *                  @OA\Property(property="grado_instruccion_id", type="number", example=1),
     *                  @OA\Property(type="object", property="tipo_documento",
     *                      @OA\Property(property="id", type="number", example=6),
     *                      @OA\Property(property="nombre", type="string", example="DNI"),
     *                      @OA\Property(property="codigo", type="number", example=1),
     *                      @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  ),
     *                  @OA\Property(type="object",property="distrito",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="distrito", type="string", example="MONTEVIDEO"),
     *                      @OA\Property(property="provincia_id", type="number", example=1),
     *                      @OA\Property(type="object",property="provincia",
     *                          @OA\Property(property="id", type="number", example=1),
     *                          @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                          @OA\Property(property="departamento_id", type="number", example=1),
     *                          @OA\Property(type="object",property="departamento",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                          ),
     *                      ),
     *                  ),
     *                  @OA\Property(type="object", property="distrito_domicilio",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="descripcion", type="string", example="No hay tabla distrito_domicilio"),
     *                  ),
     *                  @OA\Property(type="object", property="estado_civil",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Soltero(a)"),
     *                  ),
     *                  @OA\Property(type="object", property="religion",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="descripcion", type="string", example="Catolica"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  ),
     *                  @OA\Property(type="object", property="sexo",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Masculino"),
     *                  ),
     *                  @OA\Property(type="object", property="grado_instruccion",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Primaria"),
     *                  ),
     *              ),
     *          )
     *       ),
     *    ),
     *    @OA\Response(response="500",description="invalid",
     *        @OA\JsonContent(
     *            @OA\Property(property="resp", type="string", example="Persona no encontrada")
     *        )
     *    )
     * )
     */
    public function findbydni($numero_documento)
    {
        DB::beginTransaction();
        try {
            $persona = Persona::with(
                'tipo_documento',
                'distrito.provincia.departamento',
                'distrito_domicilio',
                'estado_civil',
                'religion',
                'sexo',
                'grado_instruccion'
            )->where('numero_documento', $numero_documento)->firstOrFail();
            return response()->json(["data" => $persona]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "Persona no encontrada","error" => "error " . $e],500);
        }
    }
}
