<?php

namespace App\Http\Controllers\Atencion;

use App\Http\Controllers\Controller;
use App\Models\Deporte;
use App\Models\Frecuencia;
use App\Models\Habito;
use App\Models\HabitoDeporte;
use App\Models\HabitoNocivo;
use App\Models\Tiempo;
use App\Models\TipoHabito;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabitoNocivoController extends Controller
{
    /**
     * Mostrar Datos de Habitos Nocivos
     * @OA\Get (
     *     path="/api/atencion/triaje/habitonocivo/get/{idHabitoNocivo}",
     *     summary="Mostar Datos de Habitos Nocivos",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Triaje - Habitos Nocivos"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="medicamento", type="string", example="paracetamol"),
     *                             @OA\Property(property="observaciones", type="string", example="2 veces por semana"),
     *                             @OA\Property(property="deporte", type="string", example="deporte si"),
     *                             @OA\Property(property="estado_registro", type="char", example="A"),
     *                             @OA\Property(
     *                                 type="array",
     *                                 property="habito_deporte",
     *                                 @OA\Items(
     *                                     type="object",
     *                                     @OA\Property(property="id", type="integer", example=1),
     *                                     @OA\Property(property="habito_nocivo_id", type="integer", example=1),
     *                                     @OA\Property(property="frecuencia_id", type="integer", example=1),
     *                                     @OA\Property(property="deporte_id", type="integer", example="1"),
     *                                     @OA\Property(property="tiempo_id", type="integer", example=4),
     *                                     @OA\Property(property="estado_registro", type="char", example="A"),
     *                                     @OA\Property(
     *                                         property="frecuencia", type="object",
     *                                             @OA\Property(property="id", type="integer", example="1"),
     *                                             @OA\Property(property="nombre", type="string", example="Nada"),
     *                                             @OA\Property(property="estado_registro", type="char", example="A"),
     *                                     ),
     *                                     @OA\Property(
     *                                         property="deporte", type="object",
     *                                             @OA\Property(property="id", type="integer", example=1),
     *                                             @OA\Property(property="nombre", type="string", example="Futbol"),
     *                                             @OA\Property(property="estado_registro", type="char", example="A"),
     *                                     ),
     *                                     @OA\Property(
     *                                         property="tiempo", type="object",
     *                                             @OA\Property(property="id", type="integer", example=4),
     *                                             @OA\Property(property="tipo_tiempo_id", type="integer", example=2),
     *                                             @OA\Property(property="cantidad", type="string", example=40),
     *                                             @OA\Property(property="estado_registro", type="char", example="A"),
     *                                             @OA\Property(
     *                                                 property="tipo_tiempo", type="object",
     *                                                     @OA\Property(property="id", type="integer", example=2),
     *                                                     @OA\Property(property="nombre", type="string", example="Diario"),
     *                                                     @OA\Property(property="estado_registro", type="char", example="A"),
     *                                             )
     *                                     ),
     *                                 )
     *                             ),
     *                             @OA\Property(
     *                                 type="array",
     *                                 property="habitos",
     *                                 @OA\Items(
     *                                     type="object",
     *                                     @OA\Property(property="id", type="integer", example=1),
     *                                     @OA\Property(property="tipo_habito_id", type="integer", example=1),
     *                                     @OA\Property(property="frecuencia_id", type="integer", example=2),
     *                                     @OA\Property(property="habito_nocivo_id", type="integer", example=1),
     *                                     @OA\Property(property="frecuencia", type="string", example="frecuencia"),
     *                                     @OA\Property(property="tiempo", type="string", example=10),
     *                                     @OA\Property(property="tipo", type="string", example="alto"),
     *                                     @OA\Property(property="cantidad", type="string", example=10),
     *                                     @OA\Property(property="estado_registro", type="char", example="A"),
     *                                 )
     *                             ),
     *                        )
     *                   ),
     *                   @OA\Property(type="count", property="size", example="1")
     *          )
     *      ),
     *         @OA\Response(
     *         response=400,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se encuentran los datos")
     *             )
     *         ),
     *         @OA\Response(
     *         response=500,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error al llamar Habito Nocivo, intente otra vez!")
     *             )
     *         )
     *  )
     */
    public function get($idHabitoNocivo)
    {
        try {
        $habito_nocivo = HabitoNocivo::where('estado_registro', 'A')->with(['habito_deporte.frecuencia','habito_deporte.deporte','habito_deporte.tiempo.tipo_tiempo','habitos'])->where('id',$idHabitoNocivo)->get();
        // return response()->json($habito_nocivo);
        if (!$habito_nocivo) {
            return response()->json(["error"=> "No se encuentran los datos"],400);
        }else {
        return response()->json(["data"=>$habito_nocivo,"size"=>count($habito_nocivo)]);
        }
    } catch (Exception $e) {
        return response()->json(["error" => "Error al llamar Habito Nocivo, intente otra vez! " . $e]);
    }
}

    /**
     * Crear Datos de Habitos Nocivos
     * @OA\Post(
     *     path="/api/atencion/triaje/habitonocivo/create",
     *     summary="Mostar Datos de Habitos Nocivos",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Triaje - Habitos Nocivos"},
     *      @OA\Parameter(description="clinica_servicio_id",@OA\Schema(type="foreignId"), name="clinica_servicio_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="medicamento",@OA\Schema(type="string"), name="medicamento", in="query", required=false, example="paracetamol"),
     *      @OA\Parameter(description="observaciones",@OA\Schema(type="string"), name="observaciones", in="query", required=false, example="2 veces por semana"),
     *      @OA\Parameter(description="deporte",@OA\Schema(type="string"), name="deporte", in="query", required=false, example="deporte si"),
     *      @OA\Parameter(description="habitos",@OA\Schema(type="string"), name="--------------", in="query", required=false, example="--------------"),
     *      @OA\Parameter(description="tipo_habito_id",@OA\Schema(type="integer"), name="tipo_habito_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="frecuencia_id",@OA\Schema(type="integer"), name="frecuencia_id", in="query", required=false, example="2"),
     *      @OA\Parameter(description="frecuencia",@OA\Schema(type="string"), name="frecuencia", in="query", required=false, example="frecuente"),
     *      @OA\Parameter(description="tiempo",@OA\Schema(type="string"), name="tiempo", in="query", required=false, example="10"),
     *      @OA\Parameter(description="tipo",@OA\Schema(type="string"), name="tipo", in="query", required=false, example="alto"),
     *      @OA\Parameter(description="cantidad",@OA\Schema(type="string"), name="cantidad", in="query", required=false, example="10"),
     *      @OA\Parameter(description="habito_deporte",@OA\Schema(type="string"), name="--------------", in="query", required=false, example="--------------"),
     *      @OA\Parameter(description="tipo_tiempo_id",@OA\Schema(type="integer"), name="tipo_tiempo_id", in="query", required=false, example=2),
     *      @OA\Parameter(description="cantidad",@OA\Schema(type="string"), name="cantidad", in="query", required=false, example="40"),
     *      @OA\Parameter(description="frecuencia_id",@OA\Schema(type="integer"), name="frecuencia_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="deporte_id",@OA\Schema(type="integer"), name="deporte_id", in="query", required=false, example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="medicamento", type="string",example="paracetamol"),
     *                      @OA\Property(property="observaciones", type="string",example="2 veces por semana"),
     *                      @OA\Property(property="deporte", type="string",example="deporte si"),
     *                      @OA\Property(
     *                        type="array",
     *                        property="habitos",
     *                        @OA\Items(
     *                            type="object",
     *                            @OA\Property(property="tipo_habito_id", type="integer",example=1),
     *                            @OA\Property(property="frecuencia_id", type="integer",example=2),
     *                            @OA\Property(property="frecuencia", type="string",example="frecuente"),
     *                            @OA\Property(property="tiempo", type="string",example="10"),
     *                            @OA\Property(property="tipo", type="string",example="alto"),
     *                            @OA\Property(property="cantidad", type="string",example="10"),
     *                        )
     *                     ),
     *                      @OA\Property(
     *                          type="array",
     *                          property="habito_deporte",
     *                           @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="tipo_tiempo_id", type="integer",example=2),
     *                              @OA\Property(property="cantidad", type="string",example="40"),
     *                              @OA\Property(property="frecuencia_id", type="integer",example=1),
     *                              @OA\Property(property="deporte_id", type="integer",example=1),
     *                        )
     *                     ),
     *                  ),
     *              )
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Habitos Nocivos creado correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="El id no existe")
     *             )
     *       ),
     *         @OA\Response(
     *         response=501,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="error: Habitos Nocivos no se ha creado...")
     *             )
     *         )
     * )
     */


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            //if (!ClinicaServicio::where('estado_registro', 'A')->find($request->clinica_servicio_id)) return response()->json(['error' => 'El id clincica_servicio no existe'], 404);

            $habito_nocivo = HabitoNocivo::create([
                //"clinica_servicio_id" => $request->clinica_servicio_id,
                "medicamento" => $request->medicamento,
                "observaciones" => $request->observaciones,
                "deporte" => $request->deporte
            ]);
            $habitos = $request->habitos;

            foreach ($habitos as $habito) {
                if (!TipoHabito::where('estado_registro', 'A')->find($habito['tipo_habito_id'])) return response()->json(['error' => 'El id tipo_habito no existe'], 404);
                if (!Frecuencia::where('estado_registro', 'A')->find($habito['frecuencia_id'])) return response()->json(['error' => 'El id frecuencia no existe'], 404);

                Habito::create([
                    'tipo_habito_id' => $habito['tipo_habito_id'],
                    'habito_nocivo_id' => $habito_nocivo->id,
                    'frecuencia_id' => $habito['frecuencia_id'],
                    'frecuencia' => $habito['frecuencia'],
                    'tiempo' => $habito['tiempo'] == null ? 0 : $habito['tiempo'],
                    'tipo' => $habito['tipo'],
                    'cantidad' => $habito['cantidad'],
                ]);
            }
            $habito_deporte_req = $request->habito_deporte;
            foreach($habito_deporte_req as $habito_deporte){
                if (!Tiempo::where('estado_registro', 'A')->find($habito_deporte['tipo_tiempo_id'])) return response()->json(['error' => 'El id tipo_tiempo no existe'], 404);
                if (!Frecuencia::where('estado_registro', 'A')->find($habito_deporte['frecuencia_id'])) return response()->json(['error' => 'El id tipo_tiempo no existe'], 404);
                if (!Deporte::where('estado_registro', 'A')->find($habito_deporte['deporte_id'])) return response()->json(['error' => 'El id deporte no existe'], 404);

                
                $tiempo = Tiempo::create([
                    'tipo_tiempo_id' => $habito_deporte['tipo_tiempo_id'],
                    'cantidad' => $habito_deporte['cantidad'],
                ]);
                $habito_deporte = HabitoDeporte::create([
                    'frecuencia_id' => $habito_deporte['frecuencia_id'],
                    'deporte_id' => $habito_deporte['deporte_id'] == null ? 0 : $habito_deporte['deporte_id'],
                    'tiempo_id' => $tiempo->id,
                    'habito_nocivo_id' => $habito_nocivo->id,
                ]);
        }
            // $habito_nocivo->habito_deporte_id = $habito_deporte->id;
            // $habito_nocivo->save();

            DB::commit();
            return response()->json(["resp" => "Habito Nocivo Creado Correctamente"],200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["Error" => $e], 501);
        }
    }

    /**
     * Actualizar Datos de Habitos Nocivos
     * @OA\Put(
     *     path="/api/atencion/triaje/habitonocivo/update/{idHabitoNocivo}",
     *     summary="Actualiza Datos de Habitos Nocivos",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Triaje - Habitos Nocivos"},
     *     @OA\Parameter(
     *        in="path",
     *        name="idHabitoNocivo",
     *        required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(description="medicamento",@OA\Schema(type="string"), name="medicamento", in="query", required=false, example="paracetamol"),
     *      @OA\Parameter(description="observaciones",@OA\Schema(type="string"), name="observaciones", in="query", required=false, example="2 veces por semana"),
     *      @OA\Parameter(description="deporte",@OA\Schema(type="string"), name="deporte", in="query", required=false, example="deporte si"),
     *      @OA\Parameter(description="habitos",@OA\Schema(type="string"), name="--------------", in="query", required=false, example="--------------"),
     *      @OA\Parameter(description="tipo_habito_id",@OA\Schema(type="integer"), name="tipo_habito_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="frecuencia_id",@OA\Schema(type="integer"), name="frecuencia_id", in="query", required=false, example="2"),
     *      @OA\Parameter(description="frecuencia",@OA\Schema(type="string"), name="frecuencia", in="query", required=false, example="frecuente"),
     *      @OA\Parameter(description="tiempo",@OA\Schema(type="string"), name="tiempo", in="query", required=false, example="10"),
     *      @OA\Parameter(description="tipo",@OA\Schema(type="string"), name="tipo", in="query", required=false, example="alto"),
     *      @OA\Parameter(description="cantidad",@OA\Schema(type="string"), name="cantidad", in="query", required=false, example="10"),
     *      @OA\Parameter(description="habito_deporte",@OA\Schema(type="string"), name="--------------", in="query", required=false, example="--------------"),
     *      @OA\Parameter(description="tipo_tiempo_id",@OA\Schema(type="integer"), name="tipo_tiempo_id", in="query", required=false, example=2),
     *      @OA\Parameter(description="cantidad",@OA\Schema(type="string"), name="cantidad", in="query", required=false, example="40"),
     *      @OA\Parameter(description="frecuencia_id",@OA\Schema(type="integer"), name="frecuencia_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="deporte_id",@OA\Schema(type="integer"), name="deporte_id", in="query", required=false, example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="medicamento", type="string",example="paracetamol"),
     *                      @OA\Property(property="observaciones", type="string",example="2 veces por semana"),
     *                      @OA\Property(property="deporte", type="string",example="deporte si"),
     *                      @OA\Property(
     *                        type="array",
     *                        property="habitos",
     *                        @OA\Items(
     *                            type="object",
     *                            @OA\Property(property="tipo_habito_id", type="integer",example=1),
     *                            @OA\Property(property="frecuencia_id", type="integer",example=2),
     *                            @OA\Property(property="frecuencia", type="string",example="frecuente"),
     *                            @OA\Property(property="tiempo", type="string",example="10"),
     *                            @OA\Property(property="tipo", type="string",example="alto"),
     *                            @OA\Property(property="cantidad", type="string",example="10"),
     *                        )
     *                     ),
     *                      @OA\Property(
     *                          type="array",
     *                          property="habito_deporte",
     *                           @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="tipo_tiempo_id", type="integer",example=2),
     *                              @OA\Property(property="cantidad", type="string",example="40"),
     *                              @OA\Property(property="frecuencia_id", type="integer",example=1),
     *                              @OA\Property(property="deporte_id", type="integer",example=1),
     *                        )
     *                     ),
     *                  ),
     *              )
     *   
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Habitos Nocivos creado correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="El id no existe")
     *             )
     *         ),
     *         @OA\Response(
     *         response=501,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="error: Habitos Nocivos no se ha creado...")
     *             )
     *         )
     * )
     */
    public function update(Request $request, $idHabitoNocivo)
    {
        DB::beginTransaction();
        try {
            //if (!ClinicaServicio::where('estado_registro', 'A')->find($request->clinica_servicio_id)) return response()->json(['error' => 'El id clincica_servicio no existe'], 404);

            $habito_nocivo = HabitoNocivo::where('estado_registro','A')->find($idHabitoNocivo);
            $habito_nocivo->fill([
                //"servicio_clinica" => $request->servicio_clinica,
                "medicamento" => $request->medicamento,
                "observaciones" => $request->observaciones,
                "deporte" => $request->deporte
            ])->save();
            
            Habito::where('habito_nocivo_id',$habito_nocivo->id)->update(['estado_registro' => 'I']);
            $habitos = $request->habitos;
            foreach ($habitos as $habito) {
                if (!TipoHabito::where('estado_registro', 'A')->find($habito['tipo_habito_id'])) return response()->json(['error' => 'El id tipo_habito no existe'], 404);
                if (!Frecuencia::where('estado_registro', 'A')->find($habito['frecuencia_id'])) return response()->json(['error' => 'El id frecuencia no existe'], 404);
                
                //$habito_si = Habito::where('habito_nocivo_id',$habito_nocivo->id)->first();
                Habito::updateOrCreate([
                    'habito_nocivo_id' => $habito_nocivo->id,
                ],[
                    'tipo_habito_id' => $habito['tipo_habito_id'],
                    'frecuencia_id' => $habito['frecuencia_id'],
                    'frecuencia' => $habito['frecuencia'],
                    'tiempo' => $habito['tiempo'] == null ? 0 : $habito['tiempo'],
                    'tipo' => $habito['tipo'],
                    'cantidad' => $habito['cantidad'],
                    'estado_registro'=>'A',
                ]);
            }
            
            $habito_deporte_req = $request->habito_deporte;
            foreach($habito_deporte_req as $habito_deporte){
                if (!Tiempo::where('estado_registro', 'A')->find($habito_deporte['tipo_tiempo_id'])) return response()->json(['error' => 'El id tipo_tiempo no existe'], 404);
                if (!Frecuencia::where('estado_registro', 'A')->find($habito_deporte['frecuencia_id'])) return response()->json(['error' => 'El id tipo_tiempo no existe'], 404);
                if (!Deporte::where('estado_registro', 'A')->find($habito_deporte['deporte_id'])) return response()->json(['error' => 'El id deporte no existe'], 404);

                $habito_deporte_si = HabitoDeporte::where('estado_registro','A')->where('habito_nocivo_id',$habito_nocivo->id)->first();
                HabitoDeporte::where('habito_nocivo_id',$habito_nocivo->id)->update(['estado_registro' => 'I']);

                $tiempo = Tiempo::where('estado_registro','A')->where('id',$habito_deporte_si->tiempo_id)->first();
                //Tiempo::where('id',$habito_deporte_si->tiempo_id)->update(['estado_registro' => 'I']);
                $tiempo->fill([
                        'tipo_tiempo_id' => $habito_deporte['tipo_tiempo_id'],
                        'cantidad' => $habito_deporte['cantidad'],
                        //'estado_registro'=>'A',
                    ])->save();

                $habito_deporte_si->updateOrCreate([
                    'tiempo_id' => $tiempo->id,
                    'habito_nocivo_id' => $habito_nocivo->id,
                ],[
                    'frecuencia_id' => $habito_deporte['frecuencia_id'],
                    'deporte_id' => $habito_deporte['deporte_id'] == null ? 0 : $habito_deporte['deporte_id'],
                    'estado_registro'=>'A',
                ]);
            }

            // $habito_nocivo->habito_deporte_id = $habito_deporte->id;
            // $habito_nocivo->save();

            DB::commit();
            return response()->json(["resp" => "Habito Nocivo actualizado Correctamente"],200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["Error" => "" . $e], 501);
        }
    }

    /**
     * Eliminando Datos de Habitos Nocivos
     * @OA\Delete (
     *     path="/api/atencion/triaje/habitonocivo/delete/{idHabitoNocivo}",
     *     summary = "Eliminando Datos de Habitos Nocivos",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Triaje - Habitos Nocivos"},
     *     @OA\Parameter(
     *        in="path",
     *        name="idHabitoNocivo",
     *        required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Habito Nocivo inactivado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=404,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Habito Nocivo ya inactivado o no existe"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El registro no se ha eliminado"),
     *              )
     *          ),
     * )
     */

    public function delete($idTest)
    {
        DB::beginTransaction();
        try {

                $habito_nocivo = HabitoNocivo::find($idTest);
                if ($habito_nocivo) {
                    if (!$habito_nocivo->where('estado_registro','A')->first()) return response()->json(['error' => 'El id Habito Nocivo ya inactivado'],404);
                }else if(!$habito_nocivo) return response()->json(['error' => 'Habito Nocivo no existe'],404);

                $habito_nocivo->fill([
                    'estado_registro' => 'I',
                ])->save();

                DB::commit();
            return response()->json(["resp" => "Habito Nocivo inactivado correctamente"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e],501);
        }
    }
}
