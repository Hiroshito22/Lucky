<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Acceso;
use App\Models\AccesoRol;
use App\Models\Celular;
use App\Models\Clinica;
use App\Models\Correo;
use App\Models\Empresa;
use App\Models\EmpresaContacto;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\Models\UserRol;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaContactoController extends Controller
{
    /**
     * Permite visualizar un listado de todos los registros de la tabla "EmpresaContacto"
     * @OA\Get (path="/api/empresacontacto/get",security={{ "bearerAuth": {} }},tags={"EmpresaContacto - Empresa"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="foreignId",example="1"),
     *                     @OA\Property(property="persona_id",type="foreignId",example="1"),
     *                     @OA\Property(property="empresa_id",type="foreignId",example="1"),
     *                     @OA\Property(property="user_rol_id",type="foreignId",example="1"),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                     @OA\Property(type="array",property="empresas",
     *                        @OA\Items(type="object",
     *                            @OA\Property(property="id",type="foreignId",example="1"),
     *                            @OA\Property(property="ruc",type="string",example="10 64234546 8"),
     *                            @OA\Property(property="razon_social",type="string",example="Razon Social example..."),
     *                            @OA\Property(property="responsable",type="string",example="Nombre del Responsable..."),
     *                            @OA\Property(property="nombre_comercial",type="string",example="Nombre Comercial example..."),
     *                            @OA\Property(property="latitud",type="string",example="19° 25′ 42″ N"),
     *                            @OA\Property(property="longitud",type="string",example="10°O 30°O 50°O"),
     *                            @OA\Property(property="numero_documento",type="string",example="13245678912"),
     *                            @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                            @OA\Property(property="distrito_id",type="foreignId",example="1"),
     *                            @OA\Property(property="direccion",type="string",example="Direccion example..."),
     *                            @OA\Property(property="logo",type="string",example="http://127.0.0.1:8000/storage/empresa/Logo..."),
     *                            @OA\Property(property="estado_registro",type="char",example="A")
     *                        )
     *                    ),
     *                    @OA\Property(type="array",property="personas",
     *                        @OA\Items(type="object",
     *                            @OA\Property(property="id",type="foreignId",example="1"),
     *                            @OA\Property(property="foto",type="string",example=null),
     *                            @OA\Property(property="numero_documento",type="string",example="33333333"),
     *                            @OA\Property(property="nombres",type="string",example="nombre example"),
     *                            @OA\Property(property="apellido_paterno",type="string",example="apellido paterno example"),
     *                            @OA\Property(property="apellido_materno",type="string",example="apellido materno example"),
     *                            @OA\Property(property="cargo",type="string",example="cargo example"),
     *                            @OA\Property(property="fecha_nacimiento",type="string",example="2000-10-10"),
     *                            @OA\Property(property="hobbies",type="string",example="hobbies example1"),
     *                            @OA\Property(property="celular",type="string",example=null),
     *                            @OA\Property(property="telefono",type="char",example="+51 987654322"),
     *                            @OA\Property(property="correo",type="char",example="prueba@gmail.com example"),
     *                            @OA\Property(property="direccion",type="string",example=null),
     *                            @OA\Property(property="telefono_emergencia",type="string",example=null),
     *                            @OA\Property(property="contacto_emergencia",type="string",example=null),
     *                            @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                            @OA\Property(property="distrito_id",type="foreignId",example=null),
     *                            @OA\Property(property="distrito_domicilio_id",type="foreignId",example=null),
     *                            @OA\Property(property="estado_civil_id",type="foreignId",example=null),
     *                            @OA\Property(property="religion_id",type="foreignId",example=null),
     *                            @OA\Property(property="sexo_id",type="foreignId",example=null),
     *                            @OA\Property(property="grado_instruccion_id",type="foreignId",example=null),
     *                            @OA\Property(type="array",property="tipo_documento",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="foreignId",example="1"),
     *                                    @OA\Property(property="nombre",type="string",example="DNI"),
     *                                    @OA\Property(property="codigo",type="char",example=null),
     *                                    @OA\Property(property="descripcion",type="string",example="Documento Nacional de Identidad"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A")
     *                                )
     *                            ),
     *                            @OA\Property(property="distritos",type="string",example=null),
     *                        )
     *                    )
     *                )
     *            ),
     *            @OA\Property(type="count",property="size",example="1")
     *        )
     *    ),
     *    @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="No se encuentran Registros...")
     *         )
     *     )
     * )
     */

    public function get(){
        try {
            $registro = EmpresaContacto::with(['empresas','personas.tipo_documento','personas.distrito'])->where('estado_registro', 'A')->get(); //personas->tipo_doc y distrito_id
            if(!$registro){
                return response()->json(["Error"=>"No hay Registros..."]);
            }
            return response()->json(["data"=>$registro,"size"=>count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Permite crear un registro en la tabla "EmpresaContacto"
     * @OA\Post (path="/api/empresacontacto/create",security={{ "bearerAuth": {} }},tags={"EmpresaContacto - Empresa"},
     *     @OA\Parameter(description="Nombre del Contacto de la Tabla 'Persona'",
     *          @OA\Schema(type="string"),name="nombres",in="query",required= false,example="nombre example"),
     *      @OA\Parameter(description="Apellido Paterno del Contacto",
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required= false,example="apellido paterno example"),
     *      @OA\Parameter(description="Apellido Materno del Contacto",
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required= false,example="apellido materno example"),
     *      @OA\Parameter(description="Cargo del Contacto",
     *          @OA\Schema(type="string"),name="cargo",in="query",required= false,example="cargo example"),
     *      @OA\Parameter(description="Tipo de Documento del Contacto",
     *          @OA\Schema(type="integer"),name="tipo_documento_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="Número de Documento del Contacto",
     *          @OA\Schema(type="string"),name="numero_documento",in="query",required= true,example="33333333"),
     *      @OA\Parameter(description="Número de Celular del Contacto",
     *          @OA\Schema(type="string"),name="celular",in="query",required= false,example="+51 987654321"),
     *      @OA\Parameter(description="Correo Electrónico del Contacto",
     *          @OA\Schema(type="string"),name="correo",in="query",required= false,example="prueba@gmail.com example"),
     *      @OA\Parameter(description="Fecha de Nacimiento del Contacto",
     *          @OA\Schema(type="date"),name="fecha_nacimiento",in="query",required= false,example="2000-10-10"),
     *      @OA\Parameter(description="Hobbies/Pasatiempos del Contacto",
     *          @OA\Schema(type="string"),name="hobbies",in="query",required= false,example="hobbies example"),
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="nombres",type="string",example="nombre example"),
     *                  @OA\Property(property="apellido_paterno",type="string",example="apellido paterno example"),
     *                  @OA\Property(property="apellido_materno",type="string",example="apellido materno example"),
     *                  @OA\Property(property="cargo",type="string",example="cargo example"),
     *                  @OA\Property(property="tipo_documento_id",type="foreignId",example=1),
     *                  @OA\Property(property="numero_documento",type="string",example="33333333"),
     *                  @OA\Property(property="celular",type="string",example="+51 987654321"),
     *                  @OA\Property(property="correo",type="string",example="prueba@gmail.com example"),
     *                  @OA\Property(property="fecha_nacimiento",type="date",example="2000-10-10"),
     *                  @OA\Property(property="hobbies",type="string",example="hobbies example" )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Empresa Contacto creado correctamente")
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Empresa Contacto no se ha creado...")
     *          )
     *     )
     * )
     */

    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $empresa = Empresa::where('estado_registro','A')->find($id);
                // $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
                if(!$empresa) return response()->json(["Error"=>"La Empresa se encuenta inactivado o no existe..."]);
                $tipdoc_id=TipoDocumento::where('id',$request->tipo_documento_id)->first();
                if(!$tipdoc_id) return response()-> json(["Error"=>"El ID ingresado (Tipo Documento) no existe..."]);
                $numerodoc_uni=Persona::where("numero_documento",$request->numero_documento)->first();
                if($numerodoc_uni) return response()->json(["Error"=>"El Numero Documento ya existe en otro Contacto..."]);
                $celular_uni=Persona::where("celular",$request->celular)->first();
                if($celular_uni) return response()->json(["Error"=>"El Celular ya existe en otro Contacto..."]);
                $correo_uni=Persona::where("correo",$request->correo)->first();
                if($correo_uni) return response()->json(["Error"=>"El Correo ya existe en otro Contacto..."]);

                $persona = Persona::create([
                    'nombres' => $request->nombres,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'cargo' => $request->cargo,
                    'tipo_documento_id' => $request->tipo_documento_id,
                    'numero_documento' => $request->numero_documento,
                    'celular' => $request->celular,
                    'correo' => $request->correo,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'hobbies' => $request->hobbies
                ]);
                Celular::create([
                    'celular'=>$request->celular,
                    'persona_id'=>$persona->id,
                ]);
                Correo::create([
                    'correo'=>$request->correo,
                    'persona_id'=>$persona->id,
                ]);
                EmpresaContacto::create([
                    'persona_id' => $persona->id,
                    'empresa_id' => $empresa->id,
                ]);
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Empresa Contacto creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: Empresa Contacto no se ha creado..." => $e]);
        }
    }

    /**
     * Permite actualizar un registro de la tabla "EmpresaContacto" mediante un ID
     * @OA\Put (path="/api/empresacontacto/update/{id}",security={{ "bearerAuth": {} }},tags={"EmpresaContacto - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(description="Nombre del Contacto de la Tabla Persona",
     *          @OA\Schema(type="string"),name="nombres",in="query",required= false,example="nombre example2"),
     *     @OA\Parameter(description="Apellido Paterno del Contacto",
     *          @OA\Schema(type="string"),name="apellido_paterno",in="query",required= false,example="apellido paterno example2"),
     *     @OA\Parameter(description="Apellido Materno del Contacto",
     *          @OA\Schema(type="string"),name="apellido_materno",in="query",required= false,example="apellido materno example2"),
     *     @OA\Parameter(description="Cargo del Contacto",
     *          @OA\Schema(type="string"),name="cargo",in="query",required= false,example="cargo example2"),
     *     @OA\Parameter(description="Tipo de Documento del Contacto",
     *          @OA\Schema(type="integer"),name="tipo_documento_id",in="query",required= true,example="1"),
     *     @OA\Parameter(description="Número de Documento del Contacto",
     *          @OA\Schema(type="string"),name="numero_documento",in="query",required= true,example="33333333"),
     *     @OA\Parameter(description="Número de Celular del Contacto",
     *          @OA\Schema(type="string"),name="celular",in="query",required= false,example="+51 9876543210"),
     *     @OA\Parameter(description="Correo Electrónico del Contacto",
     *          @OA\Schema(type="string"),name="correo",in="query",required= false,example="prueba@gmail.com example2"),
     *     @OA\Parameter(description="Fecha de Nacimiento del Contacto",
     *          @OA\Schema(type="date"),name="fecha_nacimiento",in="query",required= false,example="2000-10-10"),
     *     @OA\Parameter(description="Hobbies/Pasatiempos del Contacto",
     *          @OA\Schema(type="string"),name="hobbies",in="query",required= false,example="hobbies example2"),
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="nombres",type="string",example="nombre example2"),
     *                  @OA\Property(property="apellido_paterno",type="string",example="apellido paterno example2"),
     *                  @OA\Property(property="apellido_materno",type="string",example="apellido materno example2"),
     *                  @OA\Property(property="cargo",type="string",example="cargo example2"),
     *                  @OA\Property(property="tipo_documento_id",type="foreignId",example=1),
     *                  @OA\Property(property="numero_documento",type="string",example="33333333"),
     *                  @OA\Property(property="celular",type="string",example="+51 9876543210"),
     *                  @OA\Property(property="correo",type="string",example="prueba@gmail.com example2"),
     *                  @OA\Property(property="fecha_nacimiento",type="date",example="2000-10-10"),
     *                  @OA\Property(property="hobbies",type="string",example="hobbies example2")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Empresa Contacto actualizado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="Empresa Contacto no se ha actualizado...")
     *          )
     *      )
     * )
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            if($clinica)
            {
                // $registro = EmpresaContacto::where('estado_registro', 'A')->find($id);
                $registro = EmpresaContacto::with('personas')->find($id);
                if(!$registro) return response()->json(["Error" => "El Registro no se encuentra o no está activo"]);
                $tipdoc_id=TipoDocumento::where('id',$request->tipo_documento_id)->first();
                if(!$tipdoc_id) return response()-> json(["Error"=>"El ID ingresado (Tipo Documento) no existe..."]);
                $numerodoc_uni=Persona::where("numero_documento",$request->numero_documento)->where('id','!=',$registro->personas->id)->first();
                if($numerodoc_uni) return response()->json(["Error"=>"El Numero Documento ya existe en otro Contacto..."]);
                $celular_uni=Persona::where("celular",$request->celular)->where('id', '!=',$registro->personas->id)->first();
                if($celular_uni) return response()->json(["Error"=>"El Celular ya existe en otro Contacto..."]);
                $correo_uni=Persona::where("correo",$request->correo)->where('id', '!=',$registro->personas->id)->first();
                if($correo_uni) return response()->json(["Error"=>"El Correo ya existe en otro Contacto..."]);

                $persona = Persona::find($registro->personas->id);
                $persona->fill([
                    'nombres' => $request->nombres,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'cargo' => $request->cargo,
                    'tipo_documento_id' => $request->tipo_documento_id,
                    'numero_documento' => $request->numero_documento,
                    'celular' => $request->celular,
                    'correo' => $request->correo,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'hobbies' => $request->hobbies
                ])->save();
                $celular=Celular::where('persona_id', $registro->personas->id)->first();
                $celular->fill([
                    'celular'=>$request->celular,
                ])->save();
                $correo=Correo::where('persona_id', $registro->personas->id)->first();
                $correo->fill([
                    'correo'=>$request->correo,
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Empresa Contacto actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: Empresa Contacto no se ha actualizado..." => $e]);
        }
    }

    /**
     * Permite eliminar/inactivar un registro de la tabla "EmpresaContacto" mediante un ID
     * @OA\Delete (path="/api/empresacontacto/delete/{id}",security={{ "bearerAuth": {} }},tags={"EmpresaContacto - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Empresa Contacto eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="Empresa Contacto no se ha eliminado...")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            if($clinica)
            {
                $registro = EmpresaContacto::where('estado_registro', 'A')->find($id);
                if(!$registro){
                    return response()->json(["Error" => "Empresa Contacto a eliminar ya está inactivado..."]);
                }
                $registro->fill([
                    'estado_registro' => 'I',
                ])->save();
                $contacto=Persona::where('id',$registro->persona_id)->first();
                // return response()->json($contacto);
                $contacto->fill([
                    'estado_registro' => 'I',
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Empresa Contacto eliminado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: Empresa Contacto no se ha eliminado..." => $e]);
        }
    }

    /**
     * Permite activar un registro de la tabla "EmpresaContacto" mediante un ID
     * @OA\Put (path="/api/empresacontacto/active/{id}",security={{ "bearerAuth": {} }},tags={"EmpresaContacto - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Empresa Contacto activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="Empresa Contacto no se ha activado...")
     *         )
     *     )
     * )
     */

    public function active($id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            if($clinica)
            {
                $registro = EmpresaContacto::where('estado_registro', 'I')->find($id);
                if(!$registro){
                    return response()->json(["Error" => "Empresa Contacto a activar ya está activado..."]);
                }
                $registro->fill([
                    'estado_registro' => 'A',
                ])->save();
                $contacto=Persona::where('id',$registro->persona_id)->first();
                $contacto->fill([
                    'estado_registro' => 'A',
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "Empresa Contacto activado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: Empresa Contacto no se ha activado..." => $e]);
        }
    }
}
