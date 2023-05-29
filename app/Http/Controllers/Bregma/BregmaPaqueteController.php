<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\AreaMedica;
use App\Models\BregmaPaquete;
use App\Models\BregmaPaqueteArea;
use App\Models\BregmaPaqueteCapacitacion;
use App\Models\BregmaPaqueteExamen;
use App\Models\BregmaPaqueteLaboratorio;
use App\Models\Capacitacion;
use App\Models\Examen;
use App\Models\Laboratorio;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BregmaPaqueteController extends Controller
{
    /**
     * Crea un Paquete para Bregma
     * @OA\POST (
     *     path="/api/bregma/paquete/create",
     *     summary="Crea un paquete de Bregma con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Paquete"},
     *      @OA\Parameter(description="Id de  Bregma Servicio existente",
     *          @OA\Schema(type="number"), name="bregma_servicio_id", in="query", required=true, example=1
     *      ),
     *      @OA\Parameter(description="Carga un icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""
     *      ),
     *      @OA\Parameter(description="El nombre de Paquete",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="Paquete 1"
     *      ),
     *      @OA\Parameter(description="Id de capacitación",
     *          @OA\Schema(type="number"), name="capacitacion_id", in="query", required=false, example=1
     *      ),
     *      @OA\Parameter(description="Id del examén",
     *          @OA\Schema(type="number"), name="examen_id", in="query", required=false, example=1
     *      ),
     *      @OA\Parameter(description="Id de laboratorio",
     *          @OA\Schema(type="number"), name="laboratorio_id", in="query", required=false, example=1
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="bregma_servicio_id", type="foreignId", example=1),
     *                  @OA\Property(property="icono", type="string", example="null"),
     *                  @OA\Property(property="nombre", type="string", example="paquete 1"),
     *                  @OA\Property( type="array",property="areas_medicas",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *                  @OA\Property( type="array",property="examenes",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *                  @OA\Property( type="array",property="laboratorios",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *                  @OA\Property( type="array",property="capacitaciones",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="valid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Creado"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $bregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma_paquete = BregmaPaquete::create([
                "bregma_id" => $bregma->user_rol[0]->rol->bregma_id,
                "bregma_servicio_id" => $request->bregma_servicio_id,
                "icono" => $request->icono,
                "nombre" => $request->nombre
            ]);

            $sumador_areamedica_mensual = 0;
            $sumador_areamedica_anual = 0;
            foreach ($request->areas_medicas as $area_medica) {
                $pm_am = AreaMedica::find($area_medica["id"]);
                $sumador_areamedica_mensual += $pm_am->precio_mensual;
                $sumador_areamedica_anual += $pm_am->precio_anual;
                BregmaPaqueteArea::firstOrCreate([
                    "bregma_paquete_id" => $bregma_paquete->id,
                    "area_medica_id" => $area_medica["id"]
                ]);
            }

            $sumador_examen_mensual = 0;
            $sumador_examen_anual = 0;
            if ($request->examenes) {
                foreach ($request->examenes as $examen) {
                    $pm_e = Examen::find($examen["id"]);
                    $sumador_examen_mensual += $pm_e->precio_mensual;
                    $sumador_examen_anual += $pm_e->precio_anual;
                    BregmaPaqueteExamen::firstOrCreate([
                        "bregma_paquete_id" => $bregma_paquete->id,
                        "examen_id" => $examen["id"]
                    ]);
                }
            }


            $sumador_laboratorio_mensual = 0;
            $sumador_laboratorio_anual = 0;
            if ($request->laboratorios) {
                foreach ($request->laboratorios as $laboratorio) {
                    $pm_l = Laboratorio::find($laboratorio["id"]);
                    $sumador_laboratorio_mensual += $pm_l->precio_mensual;
                    $sumador_laboratorio_anual += $pm_l->precio_anual;
                    BregmaPaqueteLaboratorio::firstOrCreate([
                        "bregma_paquete_id" => $bregma_paquete->id,
                        "laboratorio_id" => $laboratorio["id"]
                    ]);
                }
            }

            $sumador_capacitacion_mensual = 0;
            $sumador_capacitacion_anual = 0;
            if ($request->capacitaciones) {
                foreach ($request->capacitaciones as $capacitacion) {
                    $pm_l = Capacitacion::find($capacitacion["id"]);
                    $sumador_capacitacion_mensual += $pm_l->precio_mensual;
                    $sumador_capacitacion_anual += $pm_l->precio_anual;
                    BregmaPaqueteCapacitacion::firstOrCreate([
                        "bregma_paquete_id" => $bregma_paquete->id,
                        "capacitacion_id" => $capacitacion["id"]
                    ]);
                }
            }

            $sumador_total_mensual = $sumador_areamedica_mensual + $sumador_examen_mensual + $sumador_laboratorio_mensual + $sumador_capacitacion_mensual;
            $sumador_total_anual = $sumador_areamedica_anual + $sumador_examen_anual + $sumador_laboratorio_anual + $sumador_capacitacion_anual;

            // return response()->json($sumador_total_anual);

            $bregma_paquete->precio_mensual = $sumador_total_mensual;
            $bregma_paquete->precio_anual = $sumador_total_anual;
            $bregma_paquete->save();

            DB::commit();
            return response()->json(["resp"=>"Paquete de bregma creado"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error " . $e]);
        }
    }

    /**
     * Actualiza un Paquete de Bregma existente
     * @OA\PUT (
     *     path="/api/bregma/paquete/update/{id}",
     *     summary="Actualiza un paquete con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Paquete"},
     *      @OA\Parameter(description="Id del paquete a actualizar",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Parameter(description="Id de  Bregma Servicio existente",
     *          @OA\Schema(type="number"), name="bregma_servicio_id", in="query", required=true, example=1
     *      ),
     *      @OA\Parameter(description="Carga un icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""
     *      ),
     *      @OA\Parameter(description="El nombre de Paquete",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="Paquete 1"
     *      ),
     *      @OA\Parameter(description="Id de capacitación",
     *          @OA\Schema(type="number"), name="capacitacion_id", in="query", required=false, example=1
     *      ),
     *      @OA\Parameter(description="Id del examén",
     *          @OA\Schema(type="number"), name="examen_id", in="query", required=false, example=1
     *      ),
     *      @OA\Parameter(description="Id de laboratorio",
     *          @OA\Schema(type="number"), name="laboratorio_id", in="query", required=false, example=1
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="bregma_servicio_id", type="foreignId", example=1),
     *                  @OA\Property(property="icono", type="string", example="null"),
     *                  @OA\Property(property="nombre", type="string", example="paquete 1"),
     *                  @OA\Property( type="array",property="areas_medicas",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *                  @OA\Property( type="array",property="examenes",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *                  @OA\Property( type="array",property="laboratorios",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *                  @OA\Property( type="array",property="capacitaciones",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id",type="number",example=1
     *                          ),
     *                      )
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Paquete actualizado"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $Idpaquete)
    {
        DB::beginTransaction();
        try {
            $bregma_paquete = BregmaPaquete::find($Idpaquete);
            if ($bregma_paquete) {
                $sumador_areamedica_mensual = 0;
                $sumador_areamedica_anual = 0;
                foreach ($request->areas_medicas as $area_medica) {
                    $pm_am = AreaMedica::find($area_medica["id"]);
                    $sumador_areamedica_mensual += $pm_am->precio_mensual;
                    $sumador_areamedica_anual += $pm_am->precio_anual;
                }

                $sumador_examen_mensual = 0;
                $sumador_examen_anual = 0;
                foreach ($request->examenes as $examen) {
                    $pm_e = Examen::find($examen["id"]);
                    $sumador_examen_mensual += $pm_e->precio_mensual;
                    $sumador_examen_anual += $pm_e->precio_anual;
                }

                $sumador_laboratorio_mensual = 0;
                $sumador_laboratorio_anual = 0;
                foreach ($request->laboratorios as $laboratorio) {
                    $pm_l = Laboratorio::find($laboratorio["id"]);
                    $sumador_laboratorio_mensual += $pm_l->precio_mensual;
                    $sumador_laboratorio_anual += $pm_l->precio_anual;
                }

                $sumador_capacitacion_mensual = 0;
                $sumador_capacitacion_anual = 0;
                foreach ($request->capacitaciones as $capacitacion) {
                    $pm_l = Capacitacion::find($capacitacion["id"]);
                    $sumador_capacitacion_mensual += $pm_l->precio_mensual;
                    $sumador_capacitacion_anual += $pm_l->precio_anual;
                }

                $sumador_total_mensual = $sumador_areamedica_mensual + $sumador_examen_mensual + $sumador_laboratorio_mensual + $sumador_capacitacion_mensual;
                $sumador_total_anual = $sumador_areamedica_anual + $sumador_examen_anual + $sumador_laboratorio_anual + $sumador_capacitacion_anual;


                $bregma_paquete->fill(array(
                    "bregma_servicio_id" => $request->bregma_servicio_id,
                    "icono" => $request->icono,
                    "nombre" => $request->nombre,
                    "precio_mensual" => $sumador_total_mensual,
                    "precio_anual" => $sumador_total_anual
                ));

                foreach ($request->areas_medicas as $area_medica) {
                    BregmaPaqueteArea::updateOrCreate([
                        "bregma_paquete_id" => $bregma_paquete->id,
                        "area_medica_id" => $area_medica["id"]
                    ]);
                }
                foreach ($request->examenes as $examen) {
                    BregmaPaqueteExamen::updateOrCreate([
                        "bregma_paquete_id" => $bregma_paquete->id,
                        "examen_id" => $examen["id"]
                    ]);
                }
                foreach ($request->laboratorios as $laboratorio) {
                    BregmaPaqueteLaboratorio::updateOrCreate([
                        "bregma_paquete_id" => $bregma_paquete->id,
                        "laboratorio_id" => $laboratorio["id"]
                    ]);
                }
                foreach ($request->capacitaciones as $capacitacion) {
                    BregmaPaqueteCapacitacion::updateOrCreate([
                        "bregma_paquete_id" => $bregma_paquete->id,
                        "capacitacion_id" => $capacitacion["id"]
                    ]);
                }
                $bregma_paquete->save();
                DB::commit();
                return response()->json(["resp" => "Paquete de bregma actualizada"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Elimina un Paquete Bregma existente mediante el Id
     * @OA\DELETE (
     *     path="/api/bregma/paquete/delete/{id}",
     *     summary="Elimina un Paquete con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Paquete"},
     *      @OA\Parameter(description="Id del paquete a eliminar",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Paquete eliminado"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al eliminar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function delete($Id)
    {
        try {
            DB::beginTransaction();
            $bregma = BregmaPaquete::find($Id);
            if ($bregma) {
                $bregma->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Paquete eliminado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Mostrar todos los Paquetes bregma
     * @OA\GET (
     *     path="/api/bregma/paquete/get",
     *     summary="Muestra los Paquetes con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Paquete"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="icono", type="string", example="Juan"),
     *              @OA\Property(property="nombre", type="string", example="juan.com"),
     *              @OA\Property(property="precio_mensual", type="number", example=1),
     *              @OA\Property(property="precio_anual", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="bregma_servicio_id", type="number", example=1),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="area_medica",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="area medica 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="capacitacion",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="capacitacion 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="examen",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="examen 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="laboratorio",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="laboratorio 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function get()
    {
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma = BregmaPaquete::with(
                'area_medica',
                'capacitacion',
                'examen',
                'laboratorio'
            )
                ->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $bregma, "size" => count($bregma)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error" . $e]);
        }
    }

    /**
     * Mostrar Paquete Seleccionado
     * @OA\GET (
     *     path="/api/bregma/paquete/show/{id_paquete}",
     *     summary="Muestra los Paquetes con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Paquete"},
     *      @OA\Parameter(description="Id del paquete a mostrar",
     *          @OA\Schema(type="number"),name="id_paquete",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="icono", type="string", example="Juan"),
     *              @OA\Property(property="nombre", type="string", example="juan.com"),
     *              @OA\Property(property="precio_mensual", type="number", example=1),
     *              @OA\Property(property="precio_anual", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="bregma_servicio_id", type="number", example=1),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="area_medica",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="area medica 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="capacitacion",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="capacitacion 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="examen",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="examen 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="laboratorio",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="laboratorio 1"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="precio_referencial", type="number", example=400),
     *                      @OA\Property(property="precio_mensual", type="number", example=100),
     *                      @OA\Property(property="precio_anual", type="number", example=1000),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function show_paquete_id($id_paquete)
    {
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $buscador = BregmaPaquete::find($id_paquete);
            if(!$buscador)return response()->json("No existe el paquete");
            $bregma = BregmaPaquete::with(
                'area_medica',
                'capacitacion',
                'examen',
                'laboratorio'
            )
                ->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)
                ->where('id',$id_paquete)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $bregma], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error" . $e]);
        }
    }

    /**
     * Devuelve todas las areas_medicas, examenes, capacitaciones, laboratorios
     * @OA\Get(
     *  path="/api/bregma/operaciones/servicios/get",
     *  summary="Muestra todas las areas_medicas, examenes, capacitaciones, laboratorios",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Bregma - Paquete"},
     *  @OA\Response(response=200, description="success",
     *      @OA\JsonContent(
     *          @OA\Property(type="array",property="areas_medicas",
     *              @OA\Items(type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="bregma_id", type="number", example=1),
     *                  @OA\Property(property="nombre", type="string", example="area medica 1"),
     *                  @OA\Property(property="icono", type="string", example="icono"),
     *                  @OA\Property(property="precio_referencial", type="number", example=400),
     *                  @OA\Property(property="precio_mensual", type="number", example=100),
     *                  @OA\Property(property="precio_anual", type="number", example=1000),
     *                  @OA\Property(property="estado_registro", type="string", example="A"),
     *              )
     *          ),
     *          @OA\Property(type="array",property="capacitaciones",
     *              @OA\Items(type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="bregma_id", type="number", example=1),
     *                  @OA\Property(property="nombre", type="string", example="capacitacion 1"),
     *                  @OA\Property(property="icono", type="string", example="icono"),
     *                  @OA\Property(property="precio_referencial", type="number", example=400),
     *                  @OA\Property(property="precio_mensual", type="number", example=100),
     *                  @OA\Property(property="precio_anual", type="number", example=1000),
     *                  @OA\Property(property="estado_registro", type="string", example="A"),
     *              )
     *          ),
     *          @OA\Property(type="array",property="examenes",
     *              @OA\Items(type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="bregma_id", type="number", example=1),
     *                  @OA\Property(property="nombre", type="string", example="examen 1"),
     *                  @OA\Property(property="icono", type="string", example="icono"),
     *                  @OA\Property(property="precio_referencial", type="number", example=400),
     *                  @OA\Property(property="precio_mensual", type="number", example=100),
     *                  @OA\Property(property="precio_anual", type="number", example=1000),
     *                  @OA\Property(property="estado_registro", type="string", example="A"),
     *              )
     *          ),
     *          @OA\Property(type="array",property="laboratorios",
     *              @OA\Items(type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="bregma_id", type="number", example=1),
     *                  @OA\Property(property="nombre", type="string", example="laboratorio 1"),
     *                  @OA\Property(property="icono", type="string", example="icono"),
     *                  @OA\Property(property="precio_referencial", type="number", example=400),
     *                  @OA\Property(property="precio_mensual", type="number", example=100),
     *                  @OA\Property(property="precio_anual", type="number", example=1000),
     *                  @OA\Property(property="estado_registro", type="string", example="A"),
     *              )
     *          ),
     *      )
     *  ),
     *  @OA\Response(response=400, description="invalid",
     *      @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *      )
     *  ),
     * )
     */
    public function get_all()
    {
        try {
            $area_medica = AreaMedica::where('estado_registro', 'A')->get();
            $capacitacion = Capacitacion::where('estado_registro', 'A')->get();
            $examenes = Examen::where('estado_registro', 'A')->get();
            $laboratorios = Laboratorio::where('estado_registro', 'A')->get();
            return response()->json([
                "areas_medicas" => $area_medica,
                "capacitaciones" => $capacitacion,
                "examenes" => $examenes,
                "laboratorios" => $laboratorios
            ], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al mostrar, intentelo de nuevo" . $e]);
        }
    }
    
}
