<?php

namespace App\Http\Controllers\Psicologia;

use App\Http\Controllers\Controller;
use App\Models\AreaCognitiva;
use App\Models\AreaEmocional;
use App\Models\Clinica;
use App\Models\DiagnosticoFinal;
use App\Models\Recomendaciones;
use App\Models\Resultado;
use App\Models\ServicioClinica;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosticoFinalController extends Controller
{

    /**
     * Mostrar Datos de DiagnosticoFinal
     * @OA\Get (
     *     path="/api/psicologia/diagnosticofinal/get",
     *     summary="Mostar Datos de DiagnosticoFinal",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example="1"),
     *                             @OA\Property(property="clinica_servicio_id", type="foreignId", example="1"),
     *                             @OA\Property(property="area_cognitiva_id", type="foreignId", example="4"),
     *                             @OA\Property(property="area_emocional_id", type="foreignId", example="2"),
     *                             @OA\Property(property="recomendaciones_id", type="foreignId", example="2"),
     *                             @OA\Property(property="resultado_id", type="foreignId", example="2"),
     *                             @OA\Property(property="estado_registro", type="char", example="A"),
     *                             @OA\Property(
     *                                 type="array",
     *                                 property="clinica_servicio",
     *                                 @OA\Items(
     *                                     type="object",
     *                                     @OA\Property(property="id", type="integer", example="1"),
     *                                     @OA\Property(property="servicio_id", type="foreignId", example=""),
     *                                     @OA\Property(property="clinica_id", type="foreignId", example="1"),
     *                                     @OA\Property(property="nombre", type="string", example="Servicio SuperPadre"),
     *                                     @OA\Property(property="icono", type="string", example=""),
     *                                     @OA\Property(property="parent_id", type="integer", example=""),
     *                                     @OA\Property(property="estado_registro", type="char", example="A"),
     *                                 )
     *                             ),
     *                             @OA\Property(
     *                                 type="array",
     *                                 property="area_cognitiva",
     *                                 @OA\Items(
     *                                     type="object",
     *                                     @OA\Property(property="id", type="integer", example="1"),
     *                                     @OA\Property(property="nombre", type="string", example="Se encuentra en la categoría Superior al promedio"),
     *                                     @OA\Property(property="estado_registro", type="char", example="A"),
     *                                 )
     *                             ),
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="area_emocional",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="nombre", type="string", example="Se aprecia colaboradora durante la entrevista"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                                  )
     *                             ),
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="recomendaciones",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="nombre", type="string", example="Reforzar inducción y capacitación en el área de seguridad laboral"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                                  )
     *                             ),
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="resultado",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="nombre", type="string", example="Apto con observación"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                                  )
     *                             ),
     *                        )
     *                   ),
     *                   @OA\Property(type="count", property="size", example="1")
     *                
     *              
     *          )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Diagnostico Final no existe")
     *             )
     *         ),
     *         @OA\Response(
     *         response=500,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Clinica Servicio, intente otra vez!")
     *             )
     *         )
     *  )
     */

    public function get()
    {
        try{
            $diagnostico_final = DiagnosticoFinal::with('clinica_servicio','area_cognitiva','area_emocional','recomendaciones','resultado')->where('estado_registro', 'A')->get();
            if (!$diagnostico_final) {
                return response()->json(['error' => 'Diagnostico Final no existe'],404);
            }
            return response()->json(["data" => $diagnostico_final, "size" => count($diagnostico_final)]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar DiagnosticoFinal, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Crear Datos de DiagnosticoFinal
     * @OA\Post(
     *     path = "/api/psicologia/diagnosticofinal/create",
     *     summary = "Creando Datos de DiagnosticoFinal",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *      @OA\Parameter(description="clinica_servicio_id",@OA\Schema(type="foreignId"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="area_cognitiva_id",@OA\Schema(type="foreignId"), name="area_cognitiva_id", in="query", required=false, example="4"),
     *      @OA\Parameter(description="area_emocional_id",@OA\Schema(type="foreignId"), name="area_emocional_id", in="query", required=false, example="2"),
     *      @OA\Parameter(description="recomendaciones_id",@OA\Schema(type="foreignId"), name="recomendaciones_id", in="query", required=false, example="2"),
     *      @OA\Parameter(description="resultado_id",@OA\Schema(type="foreignId"), name="resultado_id", in="query", required=false, example="2"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="foreignId"),
     *                      @OA\Property(property="area_cognitiva_id", type="foreignId"),
     *                      @OA\Property(property="area_emocional_id", type="foreignId"),
     *                      @OA\Property(property="recomendaciones_id", type="foreignId"),
     *                      @OA\Property(property="resultado_id", type="foreignId"),
     *                  ),
     *                  example={
     *                      "clinica_servicio_id": 1,
     *                      "area_cognitiva_id": "4",
     *                      "area_emocional_id": "2",
     *                      "recomendaciones_id":"2",
     *                      "resultado_id":"2",
     *                  }
     *              )
     *          
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Diagnostico Final creado correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="El id no existe")
     *             )
     *         ),
     *         @OA\Response(
     *         response=501,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *             )
     *         )
     * )
     */

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica){
            // $servicio_clinica = ServicioClinica::where('estado_registro', 'A')->find($request->servicio_clinica_id);
            // if (!$servicio_clinica) return response()->json(['error' => 'El id Servicio Clinica no existe'], 404);

                if(strlen($request->area_cognitiva_id) == 0) return response()->json(['resp' => 'No ingresaste el id de area_cognitiva'], 404);
                if(strlen($request->area_emocional_id) == 0) return response()->json(['resp' => 'No ingresaste el id de area_emocional'], 404);
                if(strlen($request->recomendaciones_id) == 0) return response()->json(['resp' => 'No ingresaste el id de recomendaciones'], 404);
                if(strlen($request->resultado_id) == 0) return response()->json(['resp' => 'No ingresaste el id de resultado'], 404);

                if (!AreaCognitiva::where('estado_registro', 'A')->find($request->area_cognitiva_id)) return response()->json(['error' => 'El id AreaCognitiva no existe'], 404);
                if (!AreaEmocional::where('estado_registro', 'A')->find($request->area_emocional_id)) return response()->json(['error' => 'El id AreaEmocional no existe'], 404);
                if (!Recomendaciones::where('estado_registro', 'A')->find($request->recomendaciones_id)) return response()->json(['error' => 'El id Recomendaciones no existe'], 404);
                if (!Resultado::where('estado_registro', 'A')->find($request->resultado_id)) return response()->json(['error' => 'El id Resultado no existe'], 404);
    
                DiagnosticoFinal::create([
                    'clinica_servicio_id' => $request->clinica_servicio_id,
                    'area_cognitiva_id' => $request->area_cognitiva_id,
                    'area_emocional_id' => $request->area_emocional_id,
                    'recomendaciones_id' => $request->recomendaciones_id,
                    'resultado_id' => $request->resultado_id,
                ]);
                
            }else {
                return response()->json(["Error"=>"No tiene accesos..."]);
            }



            DB::commit();
            return response()->json(["resp" => "Diagnostico Final creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(["Error" => "Error al llamar Diagnostico Final, intente otra vez!" . $e], 501);
        }
    }

    /**
     * Modificar Datos de DiagnosticoFinal
     * @OA\Put (
     *     path="/api/psicologia/diagnosticofinal/update/{idDiagFinal}",
     *     summary = "Actualizando Datos de DiagnosticoFinal",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *     @OA\Parameter(
     *         in="path",
     *         name="idDiagFinal",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="foreignId"),
     *         name="clinica_servicio_id",
     *         in="query",
     *         required= false,
     *         example="1"
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="foreignId"),
     *         name="area_cognitiva_id",
     *         in="query",
     *         required= false,
     *         example="4"
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="foreignId"),
     *         name="area_emocional_id",
     *         in="query",
     *         required= false,
     *         example="2"
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="foreignId"),
     *         name="recomendaciones_id",
     *         in="query",
     *         required= false,
     *         example="2"
     *     ),
     *     @OA\Parameter(
     *     @OA\Schema(type="foreignId"),
     *         name="resultado_id",
     *         in="query",
     *         required= false,
     *         example="2"
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="foreignId"),
     *                      @OA\Property(property="area_cognitiva_id", type="foreignId"),
     *                      @OA\Property(property="area_emocional_id", type="foreignId"),
     *                      @OA\Property(property="recomendaciones_id", type="foreignId"),
     *                      @OA\Property(property="resultado_id", type="number"),
     *                  ),
     *                  example={
     *                      "clinica_servicio_id": 1,
     *                      "area_cognitiva_id": "4",
     *                      "area_emocional_id": "2",
     *                      "recomendaciones_id":"2",
     *                      "resultado_id":"2",
     *                  }
     *              )
     *          
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Diagnostico Final actualizada correctamente")
     *         )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="El id Diagnostico Final no existe")
     *             )
     *         ),
     *         @OA\Response(
     *         response=501,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *             )
     *         )
     * )
     * 
     */

    public function update(Request $request, $idDiagFinal)
    {
        DB::beginTransaction();
        try {

            $diagnostico_final = DiagnosticoFinal::where('estado_registro', 'A')->find($idDiagFinal);
            if (!$diagnostico_final)  return response()->json(["error" => "El id Diagnostico Final no existe"], 404);

            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica){
                // $servicio_clinica = ServicioClinica::where('estado_registro', 'A')->find($request->servicio_clinica_id);
                // if (!$servicio_clinica) return response()->json(['error' => 'El id Servicio Clinica no existe'], 404);
    
                if(strlen($request->area_cognitiva_id) == 0) return response()->json(['resp' => 'No ingresaste el id de area_cognitiva'], 404);
                if(strlen($request->area_emocional_id) == 0) return response()->json(['resp' => 'No ingresaste el id de area_emocional'], 404);
                if(strlen($request->recomendaciones_id) == 0) return response()->json(['resp' => 'No ingresaste el id de recomendaciones'], 404);
                if(strlen($request->resultado_id) == 0) return response()->json(['resp' => 'No ingresaste el id de resultado'], 404);
                
                if (!AreaCognitiva::where('estado_registro', 'A')->find($request->area_cognitiva_id)) return response()->json(['error' => 'El id AreaCognitiva no existe'], 404);
                if (!AreaEmocional::where('estado_registro', 'A')->find($request->area_emocional_id)) return response()->json(['error' => 'El id AreaEmocional no existe'], 404);
                if (!Recomendaciones::where('estado_registro', 'A')->find($request->recomendaciones_id)) return response()->json(['error' => 'El id Recomendaciones no existe'], 404);
                if (!Resultado::where('estado_registro', 'A')->find($request->resultado_id)) return response()->json(['error' => 'El id Resultado no existe'], 404);
    
                $diagnostico_final->fill([
                    'clinica_servicio_id' => $request->clinica_servicio_id,
                    'area_cognitiva_id' => $request->area_cognitiva_id,
                    'area_emocional_id' => $request->area_emocional_id,
                    'recomendaciones_id' => $request->recomendaciones_id,
                    'resultado_id' => $request->resultado_id
                ])->save();
            }
            else {
                return response()->json(["Error"=>"No tiene accesos..."]);
            }

            DB::commit();

            return response()->json(["resp" => "Diagnostico Final actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error" => "" . $e], 501);
        }
    }

    /**
     * Delete Datos de DiagnosticoFinal
     * @OA\Delete (
     *     path="/api/psicologia/diagnosticofinal/delete/{idDiagFinal}",
     *     summary = "Eliminando Datos de DiagnosticoFinal",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *     @OA\Parameter(
     *         in="path",
     *         name="idDiagFinal",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Diagnostico Final inactivida correctamente")
     *         )
     *     ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Diagnostico Final ya inactivado")
     *             )
     *         )
     * )
     */
    public function delete($idDiagFinal)
    {
        DB::beginTransaction();
        try {
            
            $diagnostico_final = DiagnosticoFinal::where('estado_registro', 'A')->find($idDiagFinal);

            if (!$diagnostico_final) return response()->json(['error' => 'Diagnostico Final ya inactivado'], 404);

            $diagnostico_final->fill([
                'estado_registro' => 'I',
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Diagnostico Final  inactivado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }

    /**
     * Mostrar Datos de Area Cognitiva
     * @OA\Get (
     *     path="/api/psicologia/diagnosticofinal/area_cognitiva/get",
     *     summary="Mostar Datos de Area Cognitiva",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example="4"),
     *                             @OA\Property(property="nombre", type="string", example="Se encuentra en la categoría Superior al promedio"),
     *                             @OA\Property(property="estado_registro", type="char", example="A"), 
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="diagnostico_final",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="clinica_servicio_id", type="foreignId", example="1"),
     *                                      @OA\Property(property="area_cognitiva_id", type="foreignId", example="4"),
     *                                      @OA\Property(property="area_emocional_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="recomendaciones_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="resultado_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                                  )
     *                             ),
     *                     )
     *              
     *          ),
     *          @OA\Property(type="count", property="size", example="1")
     *     )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Area Cognitiva no existe")
     *             )
     *         )
     *  )
     */

    public function get_area_cognitiva()
    {
        try{
            $area_cognitiva = AreaCognitiva::with('diagnostico_final')->where('estado_registro', 'A')->get();
            if (!$area_cognitiva) {
                return response()->json(['error' => 'Area Cognitiva no existe'],404);
            }
            return response()->json(["data" => $area_cognitiva, "size" => count($area_cognitiva)]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Area Cognitiva, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Mostrar Datos de Area Emocional
     * @OA\Get (
     *     path="/api/psicologia/diagnosticofinal/area_emocional/get",
     *     summary="Mostar Datos de Area Emocional",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example="2"),
     *                             @OA\Property(property="nombre", type="string", example="Se aprecia colaboradora durante la entrevista"),
     *                             @OA\Property(property="estado_registro", type="char", example="A"),
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="diagnostico_final",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="clinica_servicio_id", type="foreignId", example="1"),
     *                                      @OA\Property(property="area_cognitiva_id", type="foreignId", example="4"),
     *                                      @OA\Property(property="area_emocional_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="recomendaciones_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="resultado_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                                  )
     *                             ),
     *                        )
     *                   ),
     *                   @OA\Property(type="count", property="size", example="1")
     *            
     *          )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Area Emocional no existe")
     *             )
     *         ),
     *         @OA\Response(
     *         response=500,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Area Emocional, intente otra vez!")
     *             )
     *         )
     *  )
     */

    public function get_area_emocional()
    {
        try{
            $area_emocional = AreaEmocional::with('diagnostico_final')->where('estado_registro', 'A')->get();
            if (!$area_emocional) {
                return response()->json(['error' => 'Area Emocional no existe'],404);
            }
            return response()->json(["data" => $area_emocional, "size" => count($area_emocional)]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Area Emocional, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Mostrar Datos de Recomendaciones
     * @OA\Get (
     *     path="/api/psicologia/diagnosticofinal/recomendaciones/get",
     *     summary="Mostar Datos de Recomendaciones",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example="2"),
     *                             @OA\Property(property="nombre", type="string", example="Reforzar inducción y capacitación en el área de seguridad laboral"),
     *                             @OA\Property(property="estado_registro", type="char", example="A"), 
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="diagnostico_final",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="clinica_servicio_id", type="foreignId", example="1"),
     *                                      @OA\Property(property="area_cognitiva_id", type="foreignId", example="4"),
     *                                      @OA\Property(property="area_emocional_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="recomendaciones_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="resultado_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                                  )
     *                             ),
     *                        )
     *                   ),
     *                   @OA\Property(type="count", property="size", example="1")
     *              
     *          )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Recomendaciones no existe")
     *             )
     *         ),
     *         @OA\Response(
     *         response=500,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Recomendaciones, intente otra vez!")
     *             )
     *         )
     *  )
     */
    public function get_recomendaciones()
    {
        try{
            $recomendaciones = Recomendaciones::with('diagnostico_final')->where('estado_registro', 'A')->get();
            if (!$recomendaciones) {
                return response()->json(['error' => 'Recomendaciones no existe'],404);
            }
            return response()->json(["data" => $recomendaciones, "size" => count($recomendaciones)]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Recomendaciones, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Mostrar Datos de Resultado
     * @OA\Get (
     *     path="/api/psicologia/diagnosticofinal/resultado/get",
     *     summary="Mostar Datos de Resultado",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Psicologia-DiagnosticoFinal"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example="2"),
     *                             @OA\Property(property="nombre", type="string", example="Apto con observación"),
     *                             @OA\Property(property="estado_registro", type="char", example="A"),
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="diagnostico_final",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="clinica_servicio_id", type="foreignId", example="1"),
     *                                      @OA\Property(property="area_cognitiva_id", type="foreignId", example="4"),
     *                                      @OA\Property(property="area_emocional_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="recomendaciones_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="resultado_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                                  )
     *                             ), 
     *                        )
     *                   ),
     *                   @OA\Property(type="count", property="size", example="1")
     *              
     *          )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Resultado no existe")
     *             )
     *         ),
     *         @OA\Response(
     *         response=500,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Resultado, intente otra vez!")
     *             )
     *         )
     *  )
     */
    public function get_resultado()
    {
        try{
            $resultado = Resultado::with('diagnostico_final')->where('estado_registro', 'A')->get();
            if (!$resultado) {
                return response()->json(['error' => 'Resultado no existe'],404);
            }
            return response()->json(["data" => $resultado, "size" => count($resultado)]);

        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Resultado, intente otra vez!" . $e], 500);
        }
    }
}
