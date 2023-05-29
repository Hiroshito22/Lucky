<?php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Paciente;
use App\Models\Persona;
use App\Models\Trabajador;
use App\Models\UserRol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class PacienteController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == "/recepcion/pacientes") {
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

        DB::beginTransaction();
        try {
            $paciente = Paciente::with('persona', 'user_rol')->where('estado_registro', 'A')->get();
            DB::commit();
            return response()->json(["data" => $paciente, "size" => count($paciente)], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["Error" => $e], 500);
        }
    }
    public function getPacientesTrabajadores()
    {
        // if ($this->admin() == false) {
        //     return response()->json(["resp" => "no tiene accesos"]);
        // }
        $usuario = User::find(auth()->user()->id)->roles;
        $pacientes = Paciente::join('persona', 'paciente.persona_id', 'persona.id')
            ->join('tipo_documento', 'persona.tipo_documento_id', 'tipo_documento.id')
            ->select('paciente.*', 'numero_documento', DB::raw("CONCAT(persona.nombres,' ',persona.apellido_paterno,' ',apellido_materno) as nombres_completos"))
            ->with(['hoja_ruta.areas_medicas.area_medica'])
            ->where('clinica_id', $usuario[0]->clinica_id)
            ->get();

        return response()->json(["data" => $pacientes]);
    }
    public function create(Request $request)
    {
        if ($request->tipo_usuario_id == 1) {
            $persona = Persona::firstOrCreate(
                [
                    "tipo_documento_id" => $request->tipo_documento_id,
                    "numero_documento" => $request->numero_documento,
                ],
                [
                    "nombres" => $request->nombres,
                    "apellido_paterno" => $request->apellido_paterno,
                    "apellido_materno" => $request->apellido_materno,
                    "fecha_nacimiento" => $request->fecha_nacimiento,
                    'telefono' => $request->telefono,
                    'email' => $request->email,
                    'direccion' => $request->direccion,
                    'telefono_emergencia' => $request->telefono_emergencia,
                    'contacto_emergencia' => $request->contacto_emergencia,
                    'distrito_id' => $request->distrito_id,
                    'distrito_domicilio_id' => $request->distrito_domicilio_id,
                    'estado_civil_id' => $request->estado_civil_id,
                    'religion_id' => $request->religion_id,
                    "sexo_id" => $request->sexo_id,
                    'grado_instruccion_id' => $request->grado_instruccion_id,
                    'estado_registro' => 'A',
                ]
            );
            $user = User::firstOrCreate(
                [
                    "persona_id" => $persona->id,
                    "username" => $request->numero_documento
                ],
                [
                    "password" => $request->numero_documento
                ]
            );
            $user_rol_trabajador = UserRol::updateOrCreate(
                [
                    "user_id" => $user->id,
                    "rol_id" => 3,
                ],
                [
                    "estado_registro" => "A"
                ]
            );
            $trabajador = Trabajador::updateOrCreate(
                [
                    "empresa_id" => $request->empresa_id,
                    "persona_id" => $persona->id,
                    "user_rol_id" => $user_rol_trabajador->id,
                ],
                [
                    "estado_registro" => "A",
                    "estado_trabajador" => null,
                ]
            );
            Paciente::updateOrCreate(
                [
                    "persona_id" => $persona->id,
                    "user_rol_id" => $user_rol_trabajador->id,
                ],
                []
            );
        } else {
            $persona = Persona::firstOrCreate(
                [
                    "tipo_documento_id" => $request->tipo_documento_id,
                    "numero_documento" => $request->numero_documento,
                ],
                [
                    "nombres" => $request->nombres,
                    "apellido_paterno" => $request->apellido_paterno,
                    "apellido_materno" => $request->apellido_materno,
                    "fecha_nacimiento" => $request->fecha_nacimiento,
                    'celular' => $request->celular,
                    'telefono' => $request->telefono,
                    'email' => $request->email,
                    'direccion' => $request->direccion,
                    'telefono_emergencia' => $request->telefono_emergencia,
                    'contacto_emergencia' => $request->contacto_emergencia,
                    'distrito_id' => $request->distrito_id,
                    'distrito_domicilio_id' => $request->distrito_domicilio_id,
                    'estado_civil_id' => $request->estado_civil_id,
                    'religion_id' => $request->religion_id,
                    "sexo_id" => $request->sexo_id,
                    'grado_instruccion_id' => $request->grado_instruccion_id,
                    'estado_registro' => 'A',
                ]
            );


            $user = User::firstOrCreate(
                [
                    "username" => $request->numero_documento
                ],
                [
                    "password" => $request->numero_documento
                ]
            );
            $user_rol_paciente = UserRol::updateOrCreate(
                [
                    "user_id" => $user->id,
                    "rol_id" => 3,
                ],
                [
                    "estado_registro" => "A"
                ]
            );
            Paciente::updateOrCreate(
                [
                    "persona_id" => $persona->id,
                    "user_rol_id" => $user_rol_paciente->id,
                ],
                [

                    'estado_registro' => 'A',
                ]
            );
        }
        return response()->json(["resp" => "trabajador creado correctamente"]);
    }
    public function update($idPaciente, Request $request)
    {
        $paciente = Paciente::find($idPaciente);
        $persona = Persona::find($paciente->persona_id);
        $persona->fill([
            "tipo_documento_id" => $request->tipo_documento_id,
            "numero_documento" => $request->numero_documento,
            "nombres" => $request->nombres,
            "fecha_nacimiento" => $request->fecha_nacimiento,
            "apellido_paterno" => $request->apellido_paterno,
            "apellido_materno" => $request->apellido_materno,
            "sexo_id" => $request->sexo_id,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'distrito_id' => $request->distrito_id,
            'direccion' => $request->direccion,
            'estado_civil_id' => $request->estado_civil_id,
            'grado_instruccion_id' => $request->grado_instruccion_id,
        ])->save();
        $user_rol_paciente = UserRol::find($paciente->user_rol_id);
        $user_rol_paciente->fill([
            "rol_id" => 3,
            "estado_registro" => "A"
        ])->save();
        $user = User::find($user_rol_paciente->user_id);
        $user->fill(
            [
                "username" => $request->numero_documento,
                "password" => $request->numero_documento,
            ]
        )->save();
        $paciente->fill([
            "distrito_domicilio_id" => $request->distrito_domicilio_id,
        ]);
        return response()->json(["resp" => "trabajador actualizado correctamente"]);
    }
    public function delete($idPaciente)
    {
        $paciente = Paciente::find($idPaciente);
        $user_rol_paciente = UserRol::find($paciente->user_rol_id);
        $user_rol_paciente->fill([
            "estado_registro" => "I"
        ])->save();

        $paciente->fill([
            "estado_registro" => "I",
        ])->save();
        return response()->json(["resp" => "trabajador eliminado correctamente"]);
    }
    /**
     * Obtener Datos Paciente
     * @OA\Get (
     *     path="/api/recepcion/pacientes/getme",
     *     summary="Obtiene los datos del paciente con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Paciente"},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="empresa_id", type="number", example="1"),
     *              @OA\Property(property="sucursal_id", type="number", example="1"),
     *              @OA\Property(property="subarea_id", type="number", example="1"),
     *              @OA\Property(property="persona_id", type="number", example="1"),
     *              @OA\Property(property="user_rol_id", type="number", example="1"),
     *              @OA\Property(property="cargo_id", type="number", example="1"),
     *              @OA\Property(property="tipo_trabajador_id", type="number", example="1"),
     *              @OA\Property(
     *                 type="array",
     *                 property="persona",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="numero_documento",
     *                         type="string",
     *                         example="45781221"
     *                     ),
     *                     @OA\Property(
     *                         property="nombres",
     *                         type="string",
     *                         example="juan"
     *                     ),
     *                     @OA\Property(
     *                         property="apellido_paterno",
     *                         type="string",
     *                         example="zegarra"
     *                     ),
     *                     @OA\Property(
     *                         property="apellido_materno",
     *                         type="string",
     *                         example="lopez"
     *                     ),
     *                     @OA\Property(
     *                         property="fecha_nacimiento",
     *                         type="string",
     *                         example="1998-12-12"
     *                     ),
     *                     @OA\Property(
     *                         property="celular",
     *                         type="string",
     *                         example="949597844"
     *                     ),
     *                     @OA\Property(
     *                         property="telefono",
     *                         type="string",
     *                         example="467845"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="lopez@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="direccion",
     *                         type="string",
     *                         example="calle libertad"
     *                     ),
     *                     @OA\Property(
     *                         property="telefono_emergencia",
     *                         type="string",
     *                         example="467845"
     *                     ),
     *                     @OA\Property(
     *                         property="contacto_emergencia",
     *                         type="string",
     *                         example="Alejandra Guiterrez"
     *                     ),
     *                     @OA\Property(
     *                         property="tipo_documento_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="distrito_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="distrito_domicilio_id",
     *                         type="number",
     *                         example="345"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_civil_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="religion_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="sexo_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="grado_instruccion_id",
     *                         type="number",
     *                         example="3"
     *                     ),
     *                 )
     *             ),
     *              @OA\Property(
     *                 type="array",
     *                 property="empresa",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="ruc",
     *                         type="string",
     *                         example="22457812216"
     *                     ),
     *                     @OA\Property(
     *                         property="razon_social",
     *                         type="string",
     *                         example="Empresa 1"
     *                     ),
     *                     @OA\Property(
     *                         property="responsable",
     *                         type="string",
     *                         example="Juan Lopez"
     *                     ),
     *                     @OA\Property(
     *                         property="nombre_comercial",
     *                         type="string",
     *                         example="Claro"
     *                     ),
     *                     @OA\Property(
     *                         property="latitud",
     *                         type="number",
     *                         example="-77548561684"
     *                     ),
     *                     @OA\Property(
     *                         property="longitud",
     *                         type="number",
     *                         example="-548153151"
     *                     ),
     *                     @OA\Property(
     *                         property="tipo_documento_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="user_rol_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="distrito_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="direccion",
     *                         type="string",
     *                         example="av arequipa"
     *                     ),
     *                     @OA\Property(
     *                         property="logo",
     *                         type="string",
     *                         example="foto.jpg"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 )
     *             ),
     *              @OA\Property(
     *                 type="array",
     *                 property="sucursal",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="Sucursal 1"
     *                     ),
     *                     @OA\Property(
     *                         property="direccion",
     *                         type="string",
     *                         example="AV lima"
     *                     ),
     *                     @OA\Property(
     *                         property="empresa_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="departamento_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="latitud",
     *                         type="number",
     *                         example="-77548561684"
     *                     ),
     *                     @OA\Property(
     *                         property="longitud",
     *                         type="number",
     *                         example="-548153151"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 )
     *             ),
     *              @OA\Property(
     *                 type="array",
     *                 property="subarea",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="Cobranzas"
     *                     ),
     *                     @OA\Property(
     *                         property="empresa_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="area_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 )
     *             ),
     *              @OA\Property(
     *                 type="array",
     *                 property="cargo",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="Cobranzas"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 )
     *             ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Usuario no valido"),
     *          )
     *      )
     * )
     */


    public function getMe()
    {
        $user = UserRol::where('user_id', auth()->user()->id)->where('rol_id', 3)->first();
        if (!$user || $user == 'I') {
            return response()->json(["resp" => "Usuario no valido"]);
        }
        //return response()->json($user);
        $trabajador = Trabajador::with(['persona', 'empresa', 'sucursal', 'subarea', 'cargo'])->where('user_rol_id', $user->id)->first();
        return response()->json(["data" => $trabajador]);
    }
}
