<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\AreaMedica;
use App\Models\Capacitacion;
use App\Models\Clinica;
use App\Models\ClinicaServicio;
use App\Models\ClinicaPaquete;
use App\Models\ClinicaPaqueteServicio;
use App\Models\ClinicaPersonal;
use App\Models\Contrato;
use App\Models\Examen;
use App\Models\Laboratorio;
use App\Models\PaqueteServicio;
use App\Models\Perfil;
use App\Models\PerfilArea;
use App\Models\PerfilCapacitacion;
use App\Models\PerfilExamen;
use App\Models\PerfilLaboratorio;
use App\Models\PerfilTipo;
use App\Models\TipoPerfil;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicaPaqueteController extends Controller
{
    /**
     * Permite visualizar un listado de todos los registros de la tabla "ClinicaPaquete"
     * @OA\Get (
     *     path="/api/clinica/paquete/get",
     *     summary = "Mostrando Datos de Clinica Paquete",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica - Paquete"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                     @OA\Property(property="clinica_id",type="foreignId",example="1"),
     *                     @OA\Property(property="icono",type="string",example=null),
     *                     @OA\Property(property="nombre",type="string",example="paquete2"),
     *                     @OA\Property(property="precio",type="double",example="250.15"),
     *                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                     @OA\Property(type="array",
     *                      property="perfiles",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="integer",example="1"),
     *                          @OA\Property(property="clinica_paquete_id",type="foreignId",example="1"),
     *                          @OA\Property(property="nombre",type="foreignId",example="perfil2"),
     *                          @OA\Property(property="precio",type="string",example="200.15"),
     *                          @OA\Property(property="estado_registro",type="char",example="A"),
     *                          @OA\Property(type="array",
     *                           property="entrada",
     *                           @OA\Items(type="object",
     *                               @OA\Property(property="id",type="integer",example="1"),
     *                               @OA\Property(property="perfil_id",type="foreignId",example="1"),
     *                               @OA\Property(property="tipo_perfil_id",type="foreignId",example="1"),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),
     *                               @OA\Property(type="array",
     *                                property="areas_medicas",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="area_medica_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="examenes",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="examen_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="laboratorio",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="laboratorio_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="capacitacion",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="capacitacion_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                              )
     *                           ),
     *                          @OA\Property(type="array",
     *                           property="rutina",
     *                           @OA\Items(type="object",
     *                               @OA\Property(property="id",type="integer",example="2"),
     *                               @OA\Property(property="perfil_id",type="foreignId",example="1"),
     *                               @OA\Property(property="tipo_perfil_id",type="foreignId",example="2"),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),
     *                               @OA\Property(type="array",
     *                                property="areas_medicas",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="area_medica_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="examenes",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="examen_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="laboratorio",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="laboratorio_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="capacitacion",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="capacitacion_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                              )
     *                           ),
     *                          @OA\Property(type="array",
     *                           property="salida",
     *                           @OA\Items(type="object",
     *                               @OA\Property(property="id",type="integer",example="3"),
     *                               @OA\Property(property="perfil_id",type="foreignId",example="1"),
     *                               @OA\Property(property="tipo_perfil_id",type="foreignId",example="3"),
     *                               @OA\Property(property="estado_registro",type="char",example="A"),
     *                               @OA\Property(type="array",
     *                                property="areas_medicas",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="area_medica_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="examenes",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="examen_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="laboratorio",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="laboratorio_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                               @OA\Property(type="array",
     *                                property="capacitacion",
     *                                @OA\Items(type="object",
     *                                    @OA\Property(property="id",type="integer",example="1"),
     *                                    @OA\Property(property="perfil_tipo_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="capacitacion_id",type="foreignId",example="1"),
     *                                    @OA\Property(property="estado_registro",type="char",example="A"),
     *                                   )
     *                                ),
     *                              )
     *                           ),
     *                       )
     *                    ),
     *                 )
     *
     *             ),
     *
     *             @OA\Property(type="count",property="size",example="1")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros ocupacionales"),
     *          )
     *      )
     * )
     */
    public function get()
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $user->user_rol[0]->rol->clinica_id;
            // $clinica_paquete = ClinicaPaquete::with('perfil.perfil_tipo.perfil_area.area_medica','perfil.perfil_tipo.perfil_capacitacion.capacitacion','perfil.perfil_tipo.perfil_examen.examen','perfil.perfil_tipo.perfil_laboratorio.laboratorio')->where('clinica_id', $clinica_id)->where('estado_registro','A')->get();
            $clinica_paquete = ClinicaPaquete::with(
                'perfiles.entrada.areas_medicas',
                'perfiles.entrada.examenes',
                'perfiles.entrada.laboratorio',
                'perfiles.entrada.capacitacion',
                'perfiles.rutina.areas_medicas',
                'perfiles.rutina.examenes',
                'perfiles.rutina.laboratorio',
                'perfiles.rutina.capacitacion',
                'perfiles.salida.areas_medicas',
                'perfiles.salida.examenes',
                'perfiles.salida.laboratorio',
                'perfiles.salida.capacitacion',

            )->where('clinica_id', $clinica_id)->where('estado_registro', 'A')->get();
            if (!$clinica_paquete) {
                return response()->json(['error' => 'Clinica Paquete no existe'], 500);
            }
            return response()->json(["paquetes" => $clinica_paquete, "size" => count($clinica_paquete)]);
            // return response()->json(["paquetes" => $clinica_paquete]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al mostrar Paquete, intente otra vez!" . $e], 400);
        }
    }

    /**
     * Crear Datos de Clinica Paquete
     * @OA\Post(
     *     path = "/api/clinica/paquete/create",
     *     summary = "Creando Datos de Clinica Paquete",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica - Paquete"},
     *      @OA\Parameter(description="El nombre de Clinica Paquete",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="paquete1"),
     *      @OA\Parameter(description="El id de  Clinica Paquete",
     *          @OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example="1"),
     *
     *      @OA\Parameter(description="El nombre del Perfil",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="perfil1"),
     *
     *      @OA\Parameter(description="El id de Tipo Perfil",
     *          @OA\Schema(type="integer"), name="tipo_perfil_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="El id de Area Medica",
     *          @OA\Schema(type="integer"), name="area_medica_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Capacitacion",
     *          @OA\Schema(type="integer"), name="capacitacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Examenes",
     *          @OA\Schema(type="integer"), name="examen_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Laboratorio",
     *          @OA\Schema(type="integer"), name="laboratorio_id", in="query", required=false, example="1"),
     *
     *      @OA\Parameter(description="El id de Tipo Perfil",
     *          @OA\Schema(type="integer"), name="tipo_perfil_id", in="query", required=false, example=2),
     *      @OA\Parameter(description="El id de Area Medica",
     *          @OA\Schema(type="integer"), name="area_medica_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Capacitacion",
     *          @OA\Schema(type="integer"), name="capacitacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Examenes",
     *          @OA\Schema(type="integer"), name="examen_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Laboratorio",
     *          @OA\Schema(type="integer"), name="laboratorio_id", in="query", required=false, example="1"),
     *
     *      @OA\Parameter(description="El id de Tipo Perfil",
     *          @OA\Schema(type="integer"), name="tipo_perfil_id", in="query", required=false, example=3),
     *      @OA\Parameter(description="El id de Area Medica",
     *          @OA\Schema(type="integer"), name="area_medica_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Capacitacion",
     *          @OA\Schema(type="integer"), name="capacitacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Examenes",
     *          @OA\Schema(type="integer"), name="examen_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Laboratorio",
     *          @OA\Schema(type="integer"), name="laboratorio_id", in="query", required=false, example="1"),
     *
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="nombre", type="string", example="paquete1"),
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example=1),
     *                      @OA\Property(type="array", property="perfiles",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="nombre", type="string", example="perfil1"),
     *                          @OA\Property(property="entrada",
     *                              @OA\Property(property="tipo_perfil_id", type="integer", example=1),
     *                              @OA\Property(type="array", property="area_medicas",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="area_medica_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="capacitacion",
     *                                  @OA\Items(type="object",
     *                                       @OA\Property(property="capacitacion_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="examenes",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="examen_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="laboratorio",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="laboratorio_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                          ),
     *                          @OA\Property(property="rutina",
     *                              @OA\Property(property="tipo_perfil_id", type="integer", example=1),
     *                              @OA\Property(type="array", property="area_medicas",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="area_medica_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="capacitacion",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="capacitacion_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="examenes",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="examen_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="laboratorio",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="laboratorio_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                          ),
     *                          @OA\Property(property="salida",
     *                              @OA\Property(property="tipo_perfil_id", type="integer", example=1),
     *                              @OA\Property(type="array", property="area_medicas",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="area_medica_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="capacitacion",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="capacitacion_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="examenes",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="examen_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="laboratorio",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="laboratorio_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Clinica Paquete creado correctamente")
     *         )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene accesos (Clínica)...")
     *         )
     *      ),
     *      @OA\Response(response=501, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error al crear Paquete, intente otra vez!")
     *         )
     *      )
     * )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            //verificacion de acceso
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica = Clinica::where('id', $user->user_rol[0]->rol->clinica_id)->first();
            if ($clinica) {

                //crea Clinica paquete
                $precio_medica = 0;
                $precio_capacitacion = 0;
                $precio_examen = 0;
                $precio_laboratorio = 0;
                $precio_tipo_perfil = 0;
                $precio_perfil = 0;
                $precio_paquete = 0;
                $clinica_paquete = ClinicaPaquete::create([
                    "nombre" => $request->nombre,
                    "clinica_servicio_id" => $request->clinica_servicio_id,
                    "clinica_id" => $user->user_rol[0]->rol->clinica_id,
                    "precio" => $precio_paquete
                ]);

                $perf = $request->perfiles;
                //recorre var perf hasta var perfil y crea perfil mediante id


                foreach ($perf as $perfil) {
                    $per = Perfil::create([
                        'clinica_paquete_id' => $clinica_paquete->id,
                        'nombre' => $perfil['nombre'],
                        'precio' => $precio_perfil,
                    ]);

                    // return response()->json($perfil['entrada']);
                    $entrada = $perfil['entrada'];
                    $per_tip_entrada = PerfilTipo::create([
                        'perfil_id' => $per->id,
                        'tipo_perfil_id' => $entrada['tipo_perfil_id'],
                    ]);
                    //return response()->json($request->perfiles[0]['nombress']);

                    foreach ($entrada['area_medicas'] as $area_medicas_entrada) {

                        $area_med_entrada = PerfilArea::create([
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'area_medica_id' => $area_medicas_entrada['area_medica_id'],
                        ]);
                        $area_med_entrada = AreaMedica::where('estado_registro', 'A')->find($area_medicas_entrada['area_medica_id']);
                        $area_medica_entrada = $area_med_entrada->precio_referencial + $area_med_entrada->precio_mensual + $area_med_entrada->precio_anual;
                        $precio_medica += $area_medica_entrada;
                    }
                    foreach ($entrada['capacitacion'] as $capacitacion_entrada) {
                        $capac = PerfilCapacitacion::create([
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'capacitacion_id' => $capacitacion_entrada['capacitacion_id'],
                        ]);
                        $capaci_entrada = Capacitacion::where('estado_registro', 'A')->find($capacitacion_entrada['capacitacion_id']);
                        $capacitacion_entrada = ($capaci_entrada->precio_referencial + $capaci_entrada->precio_mensual + $capaci_entrada->precio_anual);
                        $precio_capacitacion += $capacitacion_entrada;
                    }
                    foreach ($entrada['examenes'] as $examenes_entrada) {
                        $exam = PerfilExamen::create([
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'examen_id' => $examenes_entrada['examen_id'],
                        ]);
                        $exame_entrada = Examen::where('estado_registro', 'A')->find($examenes_entrada['examen_id']);
                        $examen_entrada = $exame_entrada->precio_referencial + $exame_entrada->precio_mensual + $exame_entrada->precio_anual;
                        $precio_examen += $examen_entrada;
                    }
                    foreach ($entrada['laboratorio'] as $laboratorio_entrada) {
                        $laborat = PerfilLaboratorio::create([
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'laboratorio_id' => $laboratorio_entrada['laboratorio_id'],
                        ]);
                    }

                    ///////////////////////////////////////////////////
                    $rutina = $perfil['rutina'];
                    $per_tip_rutina = PerfilTipo::create([
                        'perfil_id' => $per->id,
                        'tipo_perfil_id' => $rutina['tipo_perfil_id'],
                    ]);
                    // foreach ($perfil['rutina'] as $rutina) {
                    //     $per_tip = PerfilTipo::create([
                    //         'perfil_id' => $per->id,
                    //         'tipo_perfil_id' => $rutina['tipo_perfil_id'],
                    //     ]);

                    foreach ($rutina['area_medicas'] as $area_medicas_rutina) {
                        $area_med_rutina = PerfilArea::create([
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'area_medica_id' => $area_medicas_rutina['area_medica_id'],
                        ]);
                    }
                    foreach ($rutina['capacitacion'] as $capacitacion_rutina) {
                        $capac_rutina = PerfilCapacitacion::create([
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'capacitacion_id' => $capacitacion_rutina['capacitacion_id'],
                        ]);
                    }
                    foreach ($rutina['examenes'] as $examenes_rutina) {
                        $exam_rutina = PerfilExamen::create([
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'examen_id' => $examenes_rutina['examen_id'],
                        ]);
                    }
                    foreach ($rutina['laboratorio'] as $laboratorio_rutina) {
                        $laborat_rutina = PerfilLaboratorio::create([
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'laboratorio_id' => $laboratorio_rutina['laboratorio_id'],
                        ]);
                    }

                    ////////////////////////////////////////////////
                    $salida =  $perfil['salida'];
                    $per_tip_salida = PerfilTipo::create([
                        'perfil_id' => $per->id,
                        'tipo_perfil_id' => $salida['tipo_perfil_id'],
                    ]);
                    // foreach ($perfil['salida'] as $salida) {
                    //     $per_tip = PerfilTipo::create([
                    //         'perfil_id' => $per->id,
                    //         'tipo_perfil_id' => $salida['tipo_perfil_id'],
                    //     ]);

                    foreach ($salida['area_medicas'] as $area_medicas_salida) {
                        $area_med = PerfilArea::create([
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'area_medica_id' => $area_medicas_salida['area_medica_id'],
                        ]);
                    }
                    foreach ($salida['capacitacion'] as $capacitacion_salida) {
                        $capac = PerfilCapacitacion::create([
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'capacitacion_id' => $capacitacion_salida['capacitacion_id'],
                        ]);
                    }
                    foreach ($salida['examenes'] as $examenes_salida) {
                        $exam = PerfilExamen::create([
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'examen_id' => $examenes_salida['examen_id'],
                        ]);
                    }
                    foreach ($salida['laboratorio'] as $laboratorio_salida) {
                        $laborat = PerfilLaboratorio::create([
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'laboratorio_id' => $laboratorio_salida['laboratorio_id'],
                        ]);
                        $labo = Laboratorio::where('estado_registro', 'A')->find($laboratorio_salida['laboratorio_id']);
                        $laborato = $labo->precio_referencial + $labo->precio_mensual + $labo->precio_anual;
                        $precio_laboratorio += $laborato;
                    }
                    $precio_ti_per = $precio_medica + $precio_capacitacion + $precio_examen + $precio_laboratorio;
                    $precio_tipo_perfil += $precio_ti_per;
                    $per_tip_salida->update(['precio' => $precio_tipo_perfil]);

                    $precio_perfil += $precio_tipo_perfil;
                    $per->update(['precio' => $precio_perfil]);
                }
                $precio_paquete += $precio_perfil;
                $clinica_paquete->update(['precio' => $precio_paquete]);
            } else {
                return response()->json(["error" => "No tiene accesos (Clínica)..."], 400);
            }

            DB::commit();
            return response()->json(["resp" => "Clinica Paquete creado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => "Error al crear Paquete, intente otra vez!" . $e], 501);
        }
    }
    /**
     * Modificar los Datos de Clinica Paquete teniendo como parametro el id
     * Crear Datos de Clinica Paquete
     * @OA\Post(
     *     path = "/api/clinica/paquete/update/{Idpaquete}",
     *     summary = "Modificar los Datos de Clinica Paquete teniendo como parametro el id",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica - Paquete"},
     *      @OA\Parameter(description="Id del Paquete a actualizar",
     *          @OA\Schema(type="number"), name="Idpaquete", in="path", required=true, example=1),
     *      @OA\Parameter(description="El nombre de Clinica Paquete",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="paquete1"),
     *      @OA\Parameter(description="El id de  Clinica Paquete",
     *          @OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example="1"),
     *
     *      @OA\Parameter(description="El nombre del Perfil",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="perfil1"),
     *
     *      @OA\Parameter(description="El id de Tipo Perfil",
     *          @OA\Schema(type="integer"), name="tipo_perfil_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="El id de Area Medica",
     *          @OA\Schema(type="integer"), name="area_medica_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Capacitacion",
     *          @OA\Schema(type="integer"), name="capacitacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Examenes",
     *          @OA\Schema(type="integer"), name="examen_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Laboratorio",
     *          @OA\Schema(type="integer"), name="laboratorio_id", in="query", required=false, example="1"),
     *
     *      @OA\Parameter(description="El id de Tipo Perfil",
     *          @OA\Schema(type="integer"), name="tipo_perfil_id", in="query", required=false, example=2),
     *      @OA\Parameter(description="El id de Area Medica",
     *          @OA\Schema(type="integer"), name="area_medica_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Capacitacion",
     *          @OA\Schema(type="integer"), name="capacitacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Examenes",
     *          @OA\Schema(type="integer"), name="examen_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Laboratorio",
     *          @OA\Schema(type="integer"), name="laboratorio_id", in="query", required=false, example="1"),
     *
     *      @OA\Parameter(description="El id de Tipo Perfil",
     *          @OA\Schema(type="integer"), name="tipo_perfil_id", in="query", required=false, example=3),
     *      @OA\Parameter(description="El id de Area Medica",
     *          @OA\Schema(type="integer"), name="area_medica_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Capacitacion",
     *          @OA\Schema(type="integer"), name="capacitacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Examenes",
     *          @OA\Schema(type="integer"), name="examen_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de Laboratorio",
     *          @OA\Schema(type="integer"), name="laboratorio_id", in="query", required=false, example="1"),
     *
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="nombre", type="string", example="paquete1"),
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example=1),
     *                      @OA\Property(type="array", property="perfiles",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="nombre", type="string", example="perfil1"),
     *                          @OA\Property(property="entrada",
     *                              @OA\Property(property="tipo_perfil_id", type="integer", example=1),
     *                              @OA\Property(type="array", property="area_medicas",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="area_medica_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="capacitacion",
     *                                  @OA\Items(type="object",
     *                                       @OA\Property(property="capacitacion_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="examenes",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="examen_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="laboratorio",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="laboratorio_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                          ),
     *                          @OA\Property(property="rutina",
     *                              @OA\Property(property="tipo_perfil_id", type="integer", example=1),
     *                              @OA\Property(type="array", property="area_medicas",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="area_medica_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="capacitacion",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="capacitacion_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="examenes",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="examen_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="laboratorio",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="laboratorio_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                          ),
     *                          @OA\Property(property="salida",
     *                              @OA\Property(property="tipo_perfil_id", type="integer", example=1),
     *                              @OA\Property(type="array", property="area_medicas",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="area_medica_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="capacitacion",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="capacitacion_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="examenes",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="examen_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                              @OA\Property(type="array", property="laboratorio",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="laboratorio_id", type="integer", example=1)
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Clinica Paquete actualizado correctamente")
     *         )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error al ACtualizar Paquete, intente otra vez!")
     *         )
     *      )
     * )
     */
    public function update(Request $request, $id_cli_pa)
    {
        DB::beginTransaction();
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_paquete = ClinicaPaquete::where('estado_registro', 'A')->find($id_cli_pa);
            $precio_medica = 0;
            $precio_capacitacion = 0;
            $precio_examen = 0;
            $precio_laboratorio = 0;
            $precio_tipo_perfil = 0;
            $precio_perfil = 0;
            $precio_paquete = 0;
            $clinica_paquete->fill([
                "nombre" => $request->nombre,
                "clinica_id" => $user->user_rol[0]->rol->clinica_id,
                "clinica_servicio_id" => $request->clinica_servicio_id,
                "precio" => $request->precio,
                'estado_registro' => 'A',
            ])->save();

            $per_fil = Perfil::where('estado_registro', 'A')->where('clinica_paquete_id', $clinica_paquete->id)->first();

            $perf = $request->perfiles;

            foreach ($perf as $perfil) {
                $per = Perfil::where('estado_registro', 'A')->where('clinica_paquete_id', $clinica_paquete->id)->first();
                $per->fill([
                    'clinica_paquete_id' => $clinica_paquete->id,
                    'nombre' => $perfil['nombre'],
                    'estado_registro' => 'A',
                ])->save();

                $per_tipo = PerfilTipo::where('estado_registro', 'A')->where('perfil_id', $per_fil->id)->first();

                $entrada = $perfil['entrada'];

                $tipo_perfil_entrada = TipoPerfil::where('estado_registro', 'A')->find($entrada['tipo_perfil_id']);
                if (!$tipo_perfil_entrada) return response()->json(['error' => 'El id tipo perfil no existe'], 404);
                $per_tip_entrada = PerfilTipo::where('estado_registro', 'A')->where('perfil_id', $per_fil->id)->where('tipo_perfil_id', $tipo_perfil_entrada->id)->first();
                $per_tip_entrada->fill([
                    'perfil_id' => $per->id,
                    'tipo_perfil_id' => $entrada['tipo_perfil_id'],
                    'estado_registro' => 'A',
                ])->save();
                PerfilArea::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_entrada->id)->update(['estado_registro' => 'I']);
                foreach ($entrada['area_medicas'] as $area_medicas_entrada) {
                    $area_med_entrada = PerfilArea::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'area_medica_id' => $area_medicas_entrada['area_medica_id'],
                        ],
                        [
                            'estado_registro' => 'A',
                        ]
                    );
                }
                $precio_paquete += $precio_perfil;
                $clinica_paquete->update(['precio' => $precio_paquete]);

                PerfilCapacitacion::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_entrada->id)->update(['estado_registro' => 'I']);
                foreach ($entrada['capacitacion'] as $capacitacion_entrada) {
                    $capac = PerfilCapacitacion::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'capacitacion_id' => $capacitacion_entrada['capacitacion_id'],
                        ],
                        [
                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilExamen::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_entrada->id)->update(['estado_registro' => 'I']);
                foreach ($entrada['examenes'] as $examenes_entrada) {
                    $exam = PerfilExamen::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'examen_id' => $examenes_entrada['examen_id'],
                        ],
                        [

                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilLaboratorio::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_entrada->id)->update(['estado_registro' => 'I']);
                foreach ($entrada['laboratorio'] as $laboratorio_entrada) {
                    $laborat = PerfilLaboratorio::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_entrada->id,
                            'laboratorio_id' => $laboratorio_entrada['laboratorio_id'],
                        ],
                        [

                            'estado_registro' => 'A',
                        ]
                    );
                }
                $rutina = $perfil['rutina'];

                $tipo_perfil_rutina = TipoPerfil::where('estado_registro', 'A')->find($entrada['tipo_perfil_id']);
                if (!$tipo_perfil_rutina) return response()->json(['error' => 'El id tipo perfil no existe'], 404);
                $per_tip_rutina = PerfilTipo::where('estado_registro', 'A')->where('perfil_id', $per_fil->id)->where('tipo_perfil_id', $tipo_perfil_rutina->id)->first();
                $per_tip_rutina->fill([
                    'perfil_id' => $per->id,
                    'tipo_perfil_id' => $rutina['tipo_perfil_id'],
                    'estado_registro' => 'A',
                ])->save();
                PerfilArea::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_rutina->id)->update(['estado_registro' => 'I']);
                foreach ($rutina['area_medicas'] as $area_medicas_rutina) {
                    $area_med_rutina = PerfilArea::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'area_medica_id' => $area_medicas_rutina['area_medica_id'],
                        ],
                        [
                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilCapacitacion::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_rutina->id)->update(['estado_registro' => 'I']);
                foreach ($rutina['capacitacion'] as $capacitacion_rutina) {
                    $capac = PerfilCapacitacion::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'capacitacion_id' => $capacitacion_rutina['capacitacion_id'],
                        ],
                        [
                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilExamen::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_rutina->id)->update(['estado_registro' => 'I']);
                foreach ($rutina['examenes'] as $examenes_rutina) {
                    $exam_rutina = PerfilExamen::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'examen_id' => $examenes_rutina['examen_id'],
                        ],
                        [

                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilLaboratorio::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_rutina->id)->update(['estado_registro' => 'I']);
                foreach ($rutina['laboratorio'] as $laboratorio_rutina) {
                    $laborat_rutina = PerfilLaboratorio::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_rutina->id,
                            'laboratorio_id' => $laboratorio_rutina['laboratorio_id'],
                        ],
                        [

                            'estado_registro' => 'A',
                        ]
                    );
                }

                $salida = $perfil['salida'];
                // PerfilTipo::where('estado_registro','A')->where('perfil_id',$per_fil->id)->update(['estado_registro' => 'I']);
                // $entrada['perfil_tipo']  as $perfil_tipos) {
                $tipo_perfil_salida = TipoPerfil::where('estado_registro', 'A')->find($salida['tipo_perfil_id']);
                if (!$tipo_perfil_salida) return response()->json(['error' => 'El id tipo perfil no existe'], 404);
                $per_tip_salida = PerfilTipo::where('estado_registro', 'A')->where('perfil_id', $per_fil->id)->where('tipo_perfil_id', $tipo_perfil_salida->id)->first();
                $per_tip_salida->fill([
                    'perfil_id' => $per->id,
                    'tipo_perfil_id' => $salida['tipo_perfil_id'],

                    'estado_registro' => 'A',
                ])->save();
                PerfilArea::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_salida->id)->update(['estado_registro' => 'I']);
                foreach ($salida['area_medicas'] as $area_medicas_salida) {
                    $area_med_salida = PerfilArea::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'area_medica_id' => $area_medicas_salida['area_medica_id'],
                        ],
                        [
                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilCapacitacion::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_salida->id)->update(['estado_registro' => 'I']);
                foreach ($salida['capacitacion'] as $capacitacion_salida) {
                    $capac_salida = PerfilCapacitacion::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'capacitacion_id' => $capacitacion_salida['capacitacion_id'],
                        ],
                        [
                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilExamen::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_salida->id)->update(['estado_registro' => 'I']);
                foreach ($salida['examenes'] as $examenes_salida) {
                    $exam = PerfilExamen::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'examen_id' => $examenes_salida['examen_id'],
                        ],
                        [

                            'estado_registro' => 'A',
                        ]
                    );
                }

                PerfilLaboratorio::where('estado_registro', 'A')->where('perfil_tipo_id', $per_tip_salida->id)->update(['estado_registro' => 'I']);
                foreach ($salida['laboratorio'] as $laboratorio_salida) {
                    $laborat = PerfilLaboratorio::updateOrcreate(
                        [
                            'perfil_tipo_id' => $per_tip_salida->id,
                            'laboratorio_id' => $laboratorio_salida['laboratorio_id'],
                        ],
                        [

                            'estado_registro' => 'A',
                        ]
                    );
                }

                // if($per_tip->tipo_perfil_id===1){
                //     PerfilArea::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['area_medicas'] as $area_medicas) {
                //         $area_med = PerfilArea::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'area_medica_id'=>$area_medicas['area_medica_id'],
                //             ],
                //             [
                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilCapacitacion::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['capacitacion'] as $capacitacion) {
                //         $capac = PerfilCapacitacion::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'capacitacion_id'=>$capacitacion['capacitacion_id'],
                //             ],
                //             [
                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilExamen::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['examenes'] as $examenes) {
                //         $exam = PerfilExamen::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'examen_id'=>$examenes['examen_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilLaboratorio::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['laboratorio'] as $laboratorio) {
                //         $laborat = PerfilLaboratorio::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'laboratorio_id'=>$laboratorio['laboratorio_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }
                // }
                // else if($per_tip->tipo_perfil_id===2){
                //     // return response()->json($per_tip);
                //     PerfilArea::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['area_medicas'] as $area_medicas) {
                //         $area_med = PerfilArea::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'area_medica_id'=>$area_medicas['area_medica_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilCapacitacion::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['capacitacion'] as $capacitacion) {
                //         $capac = PerfilCapacitacion::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'capacitacion_id'=>$capacitacion['capacitacion_id'],
                //             ],
                //             [
                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilExamen::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['examenes'] as $examenes) {
                //         $exam = PerfilExamen::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'examen_id'=>$examenes['examen_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilLaboratorio::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['laboratorio'] as $laboratorio) {
                //         $laborat = PerfilLaboratorio::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'laboratorio_id'=>$laboratorio['laboratorio_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }
                // }
                // else if($per_tip->tipo_perfil_id===3){
                //     PerfilArea::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['area_medicas'] as $area_medicas) {
                //         $area_med = PerfilArea::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'area_medica_id'=>$area_medicas['area_medica_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilCapacitacion::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['capacitacion'] as $capacitacion) {
                //         $capac = PerfilCapacitacion::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'capacitacion_id'=>$capacitacion['capacitacion_id'],
                //             ],
                //             [
                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilExamen::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['examenes'] as $examenes) {
                //         $exam = PerfilExamen::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'examen_id'=>$examenes['examen_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }

                //     PerfilLaboratorio::where('estado_registro','A')->where('perfil_tipo_id',$per_tipo->id)->update(['estado_registro' => 'I']);
                //     foreach ($perfil_tipos['laboratorio'] as $laboratorio) {
                //         $laborat = PerfilLaboratorio::updateOrcreate(
                //             [
                //                 'perfil_tipo_id'=>$per_tip->id,
                //                 'laboratorio_id'=>$laboratorio['laboratorio_id'],
                //             ],
                //             [

                //                 'estado_registro'=>'A',
                //             ]);
                //     }
                // }
                // else return response()->json(["error" => "No esxiste perfil tipo"]);


            }


            DB::commit();
            return response()->json(["resp" => "Clinica Paquete actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => "Error al ACtualizar Paquete, intente otra vez!" . $e], 400);
        }
    }

    /**
     * Activar
     * @OA\Put (
     *     path = "/api/clinica/paquete/activate/{id}",
     *     summary = "Activando Datos de Clinica Paquete",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica - Paquete"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Clinica Paquete activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La Clinica Paquete no existe"),
     *              )
     *          ),
     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La Clinica Paquete ya está activado"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: La Clinica Paquete no se ha activado"),
     *              )
     *          ),
     * )
     */

    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $activate = ClinicaPaquete::where('estado_registro', 'I')->find($id);
            $exists = ClinicaPaquete::find($id);
            if (!$exists) {
                return response()->json(["error" => "La Clinica Paquete no existe"], 401);
            }
            if (!$activate) {
                return response()->json(["error" => "La Clinica Paquete ya está activado"], 402);
            }
            $activate->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Clinica Paquete activado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La Clinica Paquete no se ha activado" => $e], 501);
        }
    }

    /**
     * Delete
     * @OA\Delete (
     *     path="clinica/paquete/delete/{id}",
     *     summary = "Eliminando Datos de Clinica Paquete",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clinica - Paquete"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Clinica Paquete eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El registro  a eliminar ya está inactivado"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El registro no se ha eliminado"),
     *              )
     *          ),
     * )
     */

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_paquete = ClinicaPaquete::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if ($clinica_paquete) {
                $registro1 = ClinicaPaquete::where('estado_registro', 'I')->find($id);
                if ($registro1) return response()->json(["Error" => "El registro  a eliminar ya está inactivado"], 401);
                $registro = ClinicaPaquete::where('estado_registro', 'A')->find($id);
                if (!$registro) return response()->json(["Error" => "El registro a eliminar no se encuentra", 404]);
                $registro->fill([
                    'estado_registro' => 'I',
                ])->save();
            } else {
                return response()->json(["Error" => "No tiene acceso"]);
            }
            DB::commit();
            return response()->json(["resp" => "Clinica Paquete eliminado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El registro no se ha eliminado" => $e], 501);
        }
    }


    // public function create(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();

    //         ClinicaPaquete::create([
    //             "nombre" => $request->nombre,
    //             "clinica_id" => $request->clinica_id,
    //         ]);
    //         DB::commit();
    //         return response()->json(["resp" => "Clinica Paquete creado"]);
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         return response()->json(["resp" => "error", "error" => "Error al crear Paquete, intente otra vez!" . $e], 400);
    //     }
    // }

    /**
     *
     */
    // public function asignarServicios(Request $request, $paquete_id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $paquete = ClinicaPaquete::find($paquete_id);
    //         if (!$paquete) {
    //             return response()->json(['error' => 'El paquete no existe'], 404);
    //         }

    //         $servicio_id = $request->input('servicios', []);

    //         $existen_servicios = ClinicaServicio::where('id', $servicio_id)->exists();
    //         if (!$existen_servicios) {
    //             return response()->json(['error' => 'Los servicios no existen'], 400);
    //         }
    //         $servicios = ClinicaServicio::findOrFail($servicio_id);

    //         $paquete->servicios()->sync($servicios);
    //         DB::commit();
    //         return response()->json(['resp' => "Los servicios se han asignado correctamente al paquete"], 200);
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         return response()->json(["resp" => "error", "error" => "Error al asignar servicios al Paquete, intente otra vez!" . $e], 400);
    //     }
    // }


    /**
     *
     */
    // public function update(Request $request, $Idpaquete)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $paquete = ClinicaPaquete::find($Idpaquete);
    //         if ($paquete) {
    //             $paquete->fill([
    //                 "nombre" => $request->nombre,
    //                 "clinica_id" => $request->clinica_id,
    //             ]);
    //             $paquete->save();
    //             DB::commit();
    //             return response()->json(["resp" => "Clínica paquete actualizado"]);
    //         } else {
    //             return response()->json(["resp" => "Clínica paquete no existe en la Base de Datos"]);
    //         }
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         return response()->json(["resp" => "error", "error" => "Error al actializar Paquete, intente otra vez!" . $e], 400);
    //     }
    // }

    /**
     *
     */
    // public function delete($Id)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $paquete = ClinicaPaquete::find($Id);
    //         if ($paquete) {
    //             $paquete->fill([
    //                 "estado_registro" => "I",
    //             ])->save();
    //             DB::commit();
    //             return response()->json(["Resp" => "Clinica paquete eliminado"]);
    //         } else {
    //             return response()->json(["resp" => "Clínica paquete no existe"]);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json(["resp" => "error", "error" => "Error al eliminar Paquete, intente otra vez!" . $e], 400);
    //     }
    // }

    public function asignar_perfil($id_personal_clinica)
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $perfil = Perfil::with("clinica_paquete")->find($id_personal_clinica);
            $personal = ClinicaPersonal::find($id_personal_clinica);
            return response()->json($personal);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error  " . $e], 400);
        }
    }


    /*public function paquetes_contrato_get()
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $user->user_rol[0]->rol->clinica_id;
            if ($clinica_id) {
                $paquete_servicio = ClinicaPaqueteServicio::with('clinica_paquete', 'clinica_servicio')
                    ->get();
                $contrato = Contrato::where("clinica_id", $clinica_id)
                    ->where("bregma_id", null)
                    ->get();
                return response()->json($contrato);
            } else {
                return response()->json("No eres usuario clinica");
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error  " . $e], 400);
        }
    }*/
}
