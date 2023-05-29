<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonaController;
use App\Models\Acceso;
use App\Models\AccesoRol;
use App\Models\Atencion;
use App\Models\Cargo;
use App\Models\CelularInstitucion;
use App\Models\Clinica;
use App\Models\Contrato;
use App\Models\CorreoInstitucion;
use App\Models\Detraccion;
use App\Models\Distritos;
use App\Models\Empresa;
use App\Models\EmpresaArea;
use App\Models\EmpresaContacto;
use App\Models\EmpresaLocal;
use App\Models\EmpresaPaquete;
use App\Models\EmpresaPersonal;
use App\Models\FichaEmpresa;
use App\Models\Liquidacion;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Rubro;
use App\Models\TipoCliente;
use App\Models\TipoDocumento;
use App\Models\UserRol;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    private $Persona;
    private $CPersonal;
    public function __construct(PersonaController $Persona, EmpresaPersonalController $CPersonal)
    {
        $this->Persona = $Persona;
        $this->CPersonal = $CPersonal;
    }
    /**
     * Permite visualizar un listado de todos los registros de la tabla "Empresa"
     * @OA\Get (path="/api/empresa/get",security={{ "bearerAuth": {} }},tags={"Empresa - Empresa"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="foreignId",example=1),
     *                     @OA\Property(property="tipo_cliente_id",type="foreignId",example=2),
     *                     @OA\Property(property="bregma_id",type="foreignId",example=null),
     *                     @OA\Property(property="clinica_id",type="foreignId",example=1),
     *                     @OA\Property(property="empresa_id",type="foreignId",example=2),
     *                     @OA\Property(property="fecha_inicio",type="date",example=null),
     *                     @OA\Property(property="fecha_vencimiento",type="date",example=null),
     *                     @OA\Property(property="estado_contrato",type="integer",example=0),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                     @OA\Property(type="array",property="empresas",
     *                        @OA\Items(type="object",
     *                            @OA\Property(property="id",type="number",example="1"),
     *                            @OA\Property(property="ruc",type="string",example="10 64234546 8"),
     *                            @OA\Property(property="razon_social",type="string",example="Grupo Modesto y Asociados"),
     *                            @OA\Property(property="responsable",type="String",example="Nombre de Responsable"),
     *                            @OA\Property(property="nombre_comercial",type="String",example="Nombre Comercial"),
     *                            @OA\Property(property="latitud",type="String",example="38° 50′ 84″ N"),
     *                            @OA\Property(property="longitud",type="String",example="10°O 30°O 50°O"),
     *                            @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                            @OA\Property(property="distrito_id",type="foreignId",example="1"),
     *                            @OA\Property(property="direccion",type="string",example="dirección example..."),
     *                            @OA\Property(property="logo",type="string",example="http://localhost:8000/storage/empresa/logo"),
     *                            @OA\Property(property="estado_registro",type="char",example="A")
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="No se encuentran Registros..."),
     *          )
     *      )
     * )
     */

    public function get()
    { //solo debe listar dependiendo del usuario el valor en el campo clinica
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica = Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            // return response()->json($clinica);
            $registro = Contrato::with('empresas')->where('estado_registro', 'A')->where('clinica_id', $clinica->id)->get();
            if (count($registro) == 0) return response()->json(["Error" => "Por ahora no hay Registros Activos..."]);
            return response()->json(["data" => $registro, "size" => count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => $e], 500);
        }
    }

    /**
     * Permite visualizar un registro de la tabla "Empresa" del Usuario Logueado
     * @OA\Get (path="/api/empresa/show",security={{ "bearerAuth": {} }},tags={"Empresa - Empresa"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="ruc",type="string",example="10 64234546 8"),
     *                     @OA\Property(property="razon_social",type="string",example="Grupo Modesto y Asociados"),
     *                     @OA\Property(property="responsable",type="String",example="Nombre de Responsable"),
     *                     @OA\Property(property="nombre_comercial",type="String",example="Nombre Comercial"),
     *                     @OA\Property(property="latitud",type="String",example="38° 50′ 84″ N"),
     *                     @OA\Property(property="longitud",type="String",example="10°O 30°O 50°O"),
     *                     @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                     @OA\Property(property="distrito_id",type="foreignId",example="1"),
     *                     @OA\Property(property="direccion",type="string",example="dirección example..."),
     *                     @OA\Property(property="logo",type="string",example="http://localhost:8000/storage/empresa/logo"),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *             ),
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="Error: No se encuentran Registros..."),
     *         )
     *     )
     * )
     */

    public function show()
    {
        return response()->json(["resp" => "No tiene Empresa o no hay Registros Activos..."]);
        try {
            // return response()->json(auth()->user()->id);
            $search = User::with('user_rol.rol')->findOrFail(auth()->user()->id);
            $registro = Empresa::with(
                'tipo_documento',
                'distrito.provincia.departamento',
                'celulares',
                'correos',
            )
                ->where('estado_registro', 'A')->find($search->user_rol[0]->rol->empresa_id);
            if (!$registro) return response()->json(["resp" => "No tiene Empresa o no hay Registros Activos..."]);
            // $registro->get();
            // return response()->json(["data"=>$registro,"size"=>count($registro)]);                               //hace falta?
            return response()->json($registro);
        } catch (Exception $e) {
            return response()->json(["resp" => "No se encontro la empresa", "error" => "" . $e], 500);
        }
    }

    /**
     * Permite crear un registro para la tabla "Empresa" con relación a otra tabla "Contrato"
     * @OA\Post (path="/api/empresa/create",security={{ "bearerAuth": {} }},tags={"Empresa - Empresa"},
     *     @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Tipo Cliente'",
     *          @OA\Schema(type="integer"),name="tipo_cliente_id",in="query",required= false,example="1"),
     *     @OA\Parameter(description="El RUC de la Empresa",
     *          @OA\Schema(type="string"),name="ruc",in="query",required= false,example="10 64234546 8"),
     *      @OA\Parameter(description="La Razón social de la Empresa",
     *          @OA\Schema(type="string"),name="razon_social",in="query",required= false,example="Razon Social example..."),
     *      @OA\Parameter(description="El Responsable de la Empresa",
     *          @OA\Schema(type="String"),name="responsable",in="query",required= false,example="Nombre del Responsable..."),
     *      @OA\Parameter(description="El Nombre Comercial de la Empresa",
     *          @OA\Schema(type="string"),name="nombre_comercial",in="query",required= false,example="Nombre Comercial example..."),
     *      @OA\Parameter(description="La Latitud de la Empresa",
     *          @OA\Schema(type="string"),name="latitud",in="query",required= false,example="19° 25′ 42″ N"),
     *      @OA\Parameter(description="La Longitud de la Empresa",
     *          @OA\Schema(type="string"),name="longitud",in="query",required= false,example="10°O 30°O 50°O"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Tipo Documento'",
     *          @OA\Schema(type="integer"),name="tipo_documento_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Clínica'",
     *          @OA\Schema(type="integer"),name="distrito_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="La Dirección exacta de la Empresa",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false,example="Direccion example..."),
     *      @OA\Parameter(description="La Ubicacion exacta del mapa de la Empresa",
     *          @OA\Schema(type="string"),name="ubicacion_mapa",in="query",required= false,example="Ubicacion example...2"),
     *      @OA\Parameter(description="La fecha del Aniversario de la Empresa",
     *          @OA\Schema(type="string"),name="aniversario",in="query",required= false,example="2022-10-15"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Rubro'",
     *          @OA\Schema(type="string"),name="rubro_id",in="query",required= false,example="3"),
     *      @OA\Parameter(description="La Cantidad de trabajadores en la Empresa",
     *          @OA\Schema(type="string"),name="cantidad_trabajadores",in="query",required= false,example="14"),
     *      @OA\Parameter(description="Los años de Actividad en la Empresa",
     *          @OA\Schema(type="string"),name="años_actividad",in="query",required= false,example="8"),
     *      @OA\Parameter(description="Logo de la Empresa",
     *          @OA\Schema(type="string"),name="logo",in="query",required= false,example="Logo..."),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                     @OA\Property(property="tipo_cliente_id",type="foreignId",example=1),
     *                     @OA\Property(property="ruc",type="string",example="10 64234546 8"),
     *                     @OA\Property(property="razon_social",type="string",example="Razon Social example..."),
     *                     @OA\Property(property="responsable",type="string",example="Nombre del Responsable..."),
     *                     @OA\Property(property="nombre_comercial",type="string",example="Nombre Comercial example..."),
     *                     @OA\Property(property="latitud",type="string",example="19° 25′ 42″ N"),
     *                     @OA\Property(property="longitud",type="string",example="10°O 30°O 60°O"),
     *                     @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                     @OA\Property(property="distrito_id",type="foreignId",example="1"),
     *                     @OA\Property(property="direccion",type="string",example="Direccion example..."),
     *                     @OA\Property(property="ubicacion_mapa",type="string",example="Ubicacion example..."),
     *                     @OA\Property(property="aniversario",type="date",example="2022-10-18"),
     *                     @OA\Property(property="rubro_id",type="integer",example="2"),
     *                     @OA\Property(property="cantidad_trabajadores",type="integer",example="12"),
     *                     @OA\Property(property="años_actividad",type="integer",example="6"),
     *                     @OA\Property(property="logo",type="string",example="Logo..."),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Empresa creado correctamente"),
     *              @OA\Property(property="empresa_id", type="string", example="1"),
     *              @OA\Property(property="contrato_id", type="string", example="1"),
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Empresa no se ha creado...")
     *          )
     *      )
     * )
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
                'razon_social' => 'required'
            ];
            $mensajes = ['required' => 'No ingreso datos en al campo :attribute'];
            $validator = Validator::make($request->all(), $reglas, $mensajes);
            if ($validator->fails()) return response()->json(["error" => $validator->errors()], 400);
            if (!$existe_tipo_cliente) return response()->json(["error" => "No existe el tipo de cliente"]);
            if ($existe_numero_documento) return response()->json(["error" => "Ya existe otro registro con el numero de documento"]);
            $usuario = User::with('roles')->find(auth()->user()->id);
            $clinica = Clinica::where('numero_documento', $usuario->username)->first();
            $empresa = Empresa::updateOrCreate(
                [
                    'tipo_documento_id' => 2,
                    'numero_documento' => $request->numero_documento,
                    'ruc' => $request->ruc,
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
            $persona = $this->Persona->store_institucion($request, null, null, $empresa->id);
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
                    "nombre" => "Administrador Empresa",
                    "tipo_acceso" => 3,
                    "empresa_id" => $empresa->id
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
            $accesos = Acceso::where('tipo_acceso', 3)->where('parent_id', null)->get();
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
                'empresa_id' => $empresa->id
            ], [
                'tipo_cliente_id' => $request->tipo_cliente_id === "null" ? null : $request->tipo_cliente_id,
                'bregma_id' => null,
                'clinica_id' => $clinica->id,
                'estado_registro' => 'A'
            ]);

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->storeAs('public/empresa', $empresa->id . '-' . $request->numero_documento . '.' . $request->logo->extension());
                $image = $empresa->id . '-' . $request->numero_documento . '.' . $request->logo->extension();
            } else {
                $image = null;
            }
            $empresa->logo = $image;
            $empresa->save();
            DB::commit();
            return response()->json(["resp" => "Empresa creado correctamente", "empresa_id" => $empresa->id, "contrato_id" => $contrato->id]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite actualizar un registro de la tabla "Empresa" y el tipo de cliente de la tabla "Contrato" mediante un ID
     * @OA\Put (path="/api/empresa/update/{id}",security={{ "bearerAuth": {} }},tags={"Empresa - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Tipo Cliente'",
     *          @OA\Schema(type="integer"),name="tipo_cliente_id",in="query",required= false,example="1"),
     *     @OA\Parameter(description="El RUC de la Empresa",
     *          @OA\Schema(type="string"),name="ruc",in="query",required= false,example="10 64234546 8"),
     *      @OA\Parameter(description="La Razón social de la Empresa",
     *          @OA\Schema(type="string"),name="razon_social",in="query",required= false,example="Razon Social example...2"),
     *      @OA\Parameter(description="El Responsable de la Empresa",
     *          @OA\Schema(type="String"),name="responsable",in="query",required= false,example="Nombre del Responsable...2"),
     *      @OA\Parameter(description="El Nombre Comercial de la Empresa",
     *          @OA\Schema(type="string"),name="nombre_comercial",in="query",required= false,example="Nombre Comercial example...2"),
     *      @OA\Parameter(description="La Latitud de la Empresa",
     *          @OA\Schema(type="string"),name="latitud",in="query",required= false,example="19° 22′ 42″ N"),
     *      @OA\Parameter(description="La Longitud de la Empresa",
     *          @OA\Schema(type="string"),name="longitud",in="query",required= false,example="10°O 30°O 60°O"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Tipo Documento'",
     *          @OA\Schema(type="integer"),name="tipo_documento_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Clínica'",
     *          @OA\Schema(type="integer"),name="distrito_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="La Dirección exacta de la Empresa",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false,example="Direccion example...2"),
     *      @OA\Parameter(description="La Ubicacion exacta del mapa de la Empresa",
     *          @OA\Schema(type="string"),name="ubicacion_mapa",in="query",required= false,example="Ubicacion example...2"),
     *      @OA\Parameter(description="La fecha del Aniversario de la Empresa",
     *          @OA\Schema(type="string"),name="aniversario",in="query",required= false,example="2022-10-15"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Rubro'",
     *          @OA\Schema(type="string"),name="rubro_id",in="query",required= false,example="3"),
     *      @OA\Parameter(description="La Cantidad de trabajadores en la Empresa",
     *          @OA\Schema(type="string"),name="cantidad_trabajadores",in="query",required= false,example="14"),
     *      @OA\Parameter(description="Los años de Actividad en la Empresa",
     *          @OA\Schema(type="string"),name="años_actividad",in="query",required= false,example="8"),
     *      @OA\Parameter(description="Logo de la Empresa",
     *          @OA\Schema(type="string"),name="logo",in="query",required= false,example="Logo...2"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                     @OA\Property(property="tipo_cliente_id",type="foreignId",example=1),
     *                     @OA\Property(property="ruc",type="string",example="10 64234546 8"),
     *                     @OA\Property(property="razon_social",type="string",example="Razon Social example..."),
     *                     @OA\Property(property="responsable",type="string",example="Nombre del Responsable..."),
     *                     @OA\Property(property="nombre_comercial",type="string",example="Nombre Comercial example..."),
     *                     @OA\Property(property="latitud",type="string",example="19° 25′ 42″ N"),
     *                     @OA\Property(property="longitud",type="string",example="10°O 30°O 60°O"),
     *                     @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                     @OA\Property(property="distrito_id",type="foreignId",example="1"),
     *                     @OA\Property(property="direccion",type="string",example="Direccion example..."),
     *                     @OA\Property(property="ubicacion_mapa",type="string",example="Ubicacion example..."),
     *                     @OA\Property(property="aniversario",type="date",example="2022-10-18"),
     *                     @OA\Property(property="rubro_id",type="integer",example="2"),
     *                     @OA\Property(property="cantidad_trabajadores",type="integer",example="12"),
     *                     @OA\Property(property="años_actividad",type="integer",example="6"),
     *                     @OA\Property(property="logo",type="string",example="Logo..."),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="La Empresa ha sido actualizada correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="La Empresa no se ha actualizado..."),
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica = Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            if ($clinica) {
                $empresa = Empresa::where('estado_registro', 'A')->find($id);
                if (!$empresa) return response()->json(["Error" => "La Empresa no se encuentra activo o no existe..."]);
                // $tipdoc_id=TipoDocumento::where('id',$request->tipo_documento_id)->first();
                // if(!$tipdoc_id) return response()-> json(["Error"=>"El ID ingresado (Tipo Documento) no existe..."]);
                $dist_id = Distritos::where('id', $request->distrito_id)->first();
                if (!$dist_id) return response()->json(["Error" => "El ID ingresado (Distrito) no existe..."]);
                $rubro = Rubro::where('id', $request->rubro_id)->first();
                if (!$rubro) return response()->json(["Error" => "Selecciona un Rubro existente..."]);

                $empresa->fill([
                    'razon_social' => $request->razon_social,
                    'responsable' => $request->responsable,
                    'nombre_comercial' => $request->nombre_comercial,
                    'latitud' => $request->latitud,
                    'longitud' => $request->longitud,
                    // 'tipo_documento_id' => 2,
                    'distrito_id' => $request->distrito_id,
                    'direccion' => $request->direccion,
                    'ubicacion_mapa' => $request->ubicacion_mapa,
                    'aniversario' => $request->aniversario,
                    'rubro_id' => $request->rubro_id,
                    'cantidad_trabajadores' => $request->cantidad_trabajadores,
                    'años_actividad' => $request->años_actividad,
                    'logo' => $request->logo
                ])->save();
                $contrato = Contrato::where('empresa_id', $empresa->id)->first();
                if (!$contrato) return response()->json(["Error" => "La Empresa no tiene contrato a editar..."]);
                $contrato->fill([
                    'tipo_cliente_id' => $request->tipo_cliente_id
                ])->save();
            } else {
                return response()->json(["Error" => "No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "La Empresa ha sido actualizada correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Empresa no se ha actualizado..." => $e]);
        }
    }

    /**
     * Permite actualizar solo un registro de la tabla "Empresa" mediante un ID
     * @OA\Put (path="/api/empresa/update2/{id}",security={{ "bearerAuth": {} }},tags={"Empresa - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(description="El RUC de la Empresa",
     *          @OA\Schema(type="string"),name="ruc",in="query",required= false,example="10 64234546 8"),
     *      @OA\Parameter(description="La Razón social de la Empresa",
     *          @OA\Schema(type="string"),name="razon_social",in="query",required= false,example="Razon Social example...2"),
     *      @OA\Parameter(description="El Responsable de la Empresa",
     *          @OA\Schema(type="String"),name="responsable",in="query",required= false,example="Nombre del Responsable...2"),
     *      @OA\Parameter(description="El Nombre Comercial de la Empresa",
     *          @OA\Schema(type="string"),name="nombre_comercial",in="query",required= false,example="Nombre Comercial example...2"),
     *      @OA\Parameter(description="La Latitud de la Empresa",
     *          @OA\Schema(type="string"),name="latitud",in="query",required= false,example="19° 22′ 42″ N"),
     *      @OA\Parameter(description="La Longitud de la Empresa",
     *          @OA\Schema(type="string"),name="longitud",in="query",required= false,example="10°O 30°O 60°O"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Tipo Documento'",
     *          @OA\Schema(type="integer"),name="tipo_documento_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Clínica'",
     *          @OA\Schema(type="integer"),name="distrito_id",in="query",required= true,example="1"),
     *      @OA\Parameter(description="La Dirección exacta de la Empresa",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= false,example="Direccion example...2"),
     *      @OA\Parameter(description="La Ubicacion exacta del mapa de la Empresa",
     *          @OA\Schema(type="string"),name="ubicacion_mapa",in="query",required= false,example="Ubicacion example...2"),
     *      @OA\Parameter(description="La fecha del Aniversario de la Empresa",
     *          @OA\Schema(type="string"),name="aniversario",in="query",required= false,example="2022-10-15"),
     *      @OA\Parameter(description="El ID (Llave Primaria) de la tabla 'Rubro'",
     *          @OA\Schema(type="string"),name="rubro_id",in="query",required= false,example="3"),
     *      @OA\Parameter(description="La Cantidad de trabajadores en la Empresa",
     *          @OA\Schema(type="string"),name="cantidad_trabajadores",in="query",required= false,example="14"),
     *      @OA\Parameter(description="Los años de Actividad en la Empresa",
     *          @OA\Schema(type="string"),name="años_actividad",in="query",required= false,example="8"),
     *      @OA\Parameter(description="Logo de la Empresa",
     *          @OA\Schema(type="string"),name="logo",in="query",required= false,example="Logo...2"),
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                     @OA\Property(property="ruc",type="string",example="10 64234546 8"),
     *                     @OA\Property(property="razon_social",type="string",example="Razon Social example..."),
     *                     @OA\Property(property="responsable",type="string",example="Nombre del Responsable..."),
     *                     @OA\Property(property="nombre_comercial",type="string",example="Nombre Comercial example..."),
     *                     @OA\Property(property="latitud",type="string",example="19° 25′ 42″ N"),
     *                     @OA\Property(property="longitud",type="string",example="10°O 30°O 60°O"),
     *                     @OA\Property(property="tipo_documento_id",type="foreignId",example="1"),
     *                     @OA\Property(property="distrito_id",type="foreignId",example="1"),
     *                     @OA\Property(property="direccion",type="string",example="Direccion example..."),
     *                     @OA\Property(property="ubicacion_mapa",type="string",example="Ubicacion example..."),
     *                     @OA\Property(property="aniversario",type="date",example="2022-10-15"),
     *                     @OA\Property(property="rubro_id",type="integer",example="3"),
     *                     @OA\Property(property="cantidad_trabajadores",type="integer",example="14"),
     *                     @OA\Property(property="años_actividad",type="integer",example="8"),
     *                     @OA\Property(property="logo",type="string",example="Logo..."),
     *                     @OA\Property(property="estado_registro",type="char",example="A")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="La Empresa ha sido actualizada correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="La Empresa no se ha actualizado..."),
     *         )
     *     )
     * )
     */

    public function updateMe(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica = Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            return response()->json($usuario);
            if ($clinica) {
                $empresa = Empresa::where('estado_registro', 'A')->find($usuario);
                if (!$empresa) return response()->json(["Error" => "La Empresa no se encuentra activo o no existe..."]);
                // $tipdoc_id=TipoDocumento::where('id',$request->tipo_documento_id)->first();
                // if(!$tipdoc_id) return response()-> json(["Error"=>"El ID ingresado (Tipo Documento) no existe..."]);
                $dist_id = Distritos::where('id', $request->distrito_id)->first();
                if (!$dist_id) return response()->json(["Error" => "El ID ingresado (Distrito) no existe..."]);

                $empresa->fill([
                    'razon_social' => $request->razon_social,
                    'responsable' => $request->responsable,
                    'nombre_comercial' => $request->nombre_comercial,
                    'latitud' => $request->latitud,
                    'longitud' => $request->longitud,
                    'distrito_id' => $request->distrito_id,
                    'direccion' => $request->direccion,
                    'ubicacion_mapa' => $request->ubicacion_mapa,
                    'aniversario' => $request->aniversario,
                    'rubro_id' => $request->rubro_id,
                    'cantidad_trabajadores' => $request->cantidad_trabajadores,
                    'años_actividad' => $request->años_actividad,
                    'logo' => $request->logo
                ])->save();
            } else {
                return response()->json(["Error" => "No tiene accesos (Clínica)..."]);
            }
            DB::commit();
            return response()->json(["resp" => "La Empresa ha sido actualizada correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Empresa no se ha actualizado..." => $e]);
        }
    }

    /**
     * Permite eliminar/inactivar un registro de la tabla "Empresa" mediante un ID
     * @OA\Delete (
     *     path="/api/empresa/delete/{id}",security={{ "bearerAuth": {} }},tags={"Empresa - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Empresa eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Empresa no se ha eliminado..."),
     *          )
     *     )
     * )
     */

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            // $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            // $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            // if($clinica)
            // {
            $empresa = Empresa::find($id);
            if (!$empresa) {
                return response()->json(["Error" => "La Empresa a eliminar ya está inactivado..."]);
            }
            $trabajadores = EmpresaPersonal::where('empresa_id', $empresa->id)->get();
            foreach ($trabajadores as $trabajador) {
                $this->CPersonal->delete($trabajador->id);
            }
            // return response()->json($empresa);
            $empresa->fill([
                'estado_registro' => 'I'
            ])->save();
            $usuario = User::where('username', $empresa->ruc)->first();
            // return response()->json($usuario);
            if (!$usuario) return response()->json(["Error" => "La Empresa no tiene un registro 'User' a eliminar..."]);
            $usuario->fill([
                'estado_registro' => 'I'
            ])->save();
            $contrato = Contrato::with('empresa')->where('empresa_id', $empresa->id)->first(); // de esta manera o con una condicional (if contrato)? / semilla empresa sin contrato
            // return response()->json($contrato);
            if (!$contrato) return response()->json(["Error" => "La Empresa no tiene un registro 'Contrato' a eliminar..."]);
            $contrato->fill([
                'estado_registro' => 'I'
            ])->save();

            // }else{
            //     return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            // }
            DB::commit();
            return response()->json(["resp" => "Empresa eliminado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Empresa no se ha eliminado..." => $e]);
        }
    }


    /**
     * Permite eliminar/inactivar un registro de la tabla "Empresa" mediante un ID
     * @OA\Delete (
     *      path="/api/empresa/destroy/{id}",
     *      summary="Elimina por completo una empresa teniendo como parametro el id de la empresa con sesión iniciada",
     *      security={{ "bearerAuth": {} }},
     *      tags={"Empresa - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Empresa eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Empresa no se ha eliminado..."),
     *          )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $user->user_rol[0]->rol->clinica_id;
            if (!$clinica_id) return response()->json(["error" => "No inicio sesión como clinica"]);
            $empresa = Empresa::find($id);
            if (!$empresa) return response()->json(["error" => "No existe la empresa"]);
            $empresa->fill([
                "tipo_documento_id" => null,
                "distrito_id" => null,
                "rubro_id" => null,
            ]);
            Rol::where('empresa_id',$id)->update(["empresa_id" => null]);
            EmpresaPersonal::where('empresa_id',$id)->update(["empresa_id" => null]);
            EmpresaArea::where('empresa_id',$id)->update(["empresa_id" => null]);
            EmpresaContacto::where('empresa_id',$id)->update(["empresa_id" => null]);
            EmpresaLocal::where('empresa_id',$id)->update(["empresa_id" => null]);
            EmpresaPaquete::where('empresa_id',$id)->update(["empresa_id" => null]);
            CelularInstitucion::where('empresa_id',$id)->update(["empresa_id" => null]);
            CorreoInstitucion::where('empresa_id',$id)->update(["empresa_id" => null]);
            Contrato::where('empresa_id',$id)->update(["empresa_id" => null]);
            Detraccion::where('empresa_id',$id)->update(["empresa_id" => null]);
            Cargo::where('empresa_id',$id)->update(["empresa_id" => null]);
            FichaEmpresa::where('empresa_id',$id)->update(["empresa_id" => null]);
            Liquidacion::where('empresa_id',$id)->update(["empresa_id" => null]);
            Atencion::where('empresa_id',$id)->update(["empresa_id" => null]);
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
     * Permite activar un registro de la tabla "Empresa" mediante un ID
     * @OA\Put (
     *     path="/api/empresa/active/{id}",security={{ "bearerAuth": {} }},tags={"Empresa - Empresa"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Empresa activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="Error", type="string", example="La Empresa no se ha activado..."),
     *          )
     *     )
     * )
     */

    public function active($id)
    {
        DB::beginTransaction();
        try {
            // $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            // $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            // if($clinica)
            // {
            $empresa = Empresa::with('contratos')->where('estado_registro', 'I')->find($id);
            if (!$empresa) {
                return response()->json(["Error" => "La Empresa a activar ya está activado..."]);
            }
            $trabajadores = EmpresaPersonal::where('empresa_id', $empresa->id)->get();
            foreach ($trabajadores as $trabajador) {
                $this->CPersonal->activar($trabajador->id);
            }
            // return response()->json($empresa);
            $empresa->fill([
                'estado_registro' => 'A'
            ])->save();
            $usuario = User::where('username', $empresa->ruc)->first();
            // return response()->json($usuario);
            if (!$usuario) return response()->json(["Error" => "La Empresa no tiene un registro 'User' a activar..."]);
            $usuario->fill([
                'estado_registro' => 'A'
            ])->save();
            $contrato = Contrato::with('empresa')->where('empresa_id', $empresa->id)->first(); // de esta manera o con una condicional (if contrato)? / semilla empresa sin contrato
            // return response()->json($contrato);
            if (!$contrato) return response()->json(["Error" => "La Empresa no tiene un registro 'Contrato' a activar..."]);
            $contrato->fill([
                'estado_registro' => 'A'
            ])->save();
            // }else{
            //     return response()->json(["Error"=>"No tiene accesos (Clínica)..."]);
            // }
            DB::commit();
            return response()->json(["resp" => "Empresa activado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Empresa no se ha activado..." => $e]);
        }
    }

    public function getrubro()
    {
        try {
            $registro = Rubro::where('estado_registro', 'A')->get();
            if (count($registro) == 0) return response()->json(["Error" => "Por ahora no hay Registros Activos..."]);
            return response()->json(["data" => $registro, "size" => count($registro)]);
        } catch (Exception $e) {
            return response()->json(["Error: No se encuentran Registros..." => "" . $e], 500);
        }
    }
}
