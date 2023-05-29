<?php

namespace App\Http\Controllers\Oftalmologia;

use App\Http\Controllers\Controller;
use App\Models\Circulos;
use App\Models\Clinica;
use App\Models\Estereopsis;
use App\Models\ExamenSegmentado;
use App\Models\Segmento;
use App\Models\StereoFlyTest;
use App\Models\Test;
use App\Models\VisionColores;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Mostrar Datos de Test-Oftalmologia
     * @OA\Get (
     *     path="/api/oftalmologia/test/get",
     *     summary="Mostrar Datos de Test-Oftalmologia",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Test-Oftalmologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array",property="data",
     *                 @OA\Items(
     *                   type="object",
     *                     @OA\Property(property="id",type="integer"),
     *                     @OA\Property(property="clinica_servicio_id",type="foreignId"),
     *                     @OA\Property(property="vision_colores_id",type="foreignId"),
     *                     @OA\Property(property="reconoce_colores",type="integer"),
     *                     @OA\Property(property="dificultad_color",type="integer"),
     *                     @OA\Property(property="estereopsis_id",type="foreignId"),
     *                     @OA\Property(property="examen_segmentado_id",type="foreignId"),
     *                     @OA\Property(property="estado_registro",type="char"),
     *                     @OA\Property(
     *                        type="array",
     *                        property="clinica_servicio",
     *                        @OA\Items(
     *                            type="object",
     *                            @OA\Property(property="id", type="integer"),
     *                            @OA\Property(property="servicio_id", type="foreignId"),
     *                            @OA\Property(property="clinica_id", type="foreignId"),
     *                            @OA\Property(property="nombre", type="string"),
     *                            @OA\Property(property="icono", type="string"),
     *                            @OA\Property(property="parent_id", type="integer"),
     *                            @OA\Property(property="estado_registro", type="char"),
     *                        )
     *                     ),
     *                     @OA\Property(
     *                         type="array",
     *                         property="vision_colores",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer"),
     *                             @OA\Property(property="ojo_derecho", type="string"),
     *                             @OA\Property(property="ojo_izquierdo", type="string"),
     *                             @OA\Property(property="estado_registro", type="char"),
     *                         )
     *                     ),
     *                     @OA\Property(
     *                          type="array",
     *                          property="estereopsis",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer"),
     *                              @OA\Property(property="stereo_fly_test_id", type="foreignId"),
     *                              @OA\Property(property="circulos_id", type="foreignId"),
     *                              @OA\Property(property="movimiento_ocular_tropias", type="string"),
     *                              @OA\Property(property="estado_registro", type="char"),
     *                              @OA\Property(
     *                                  type="array",
     *                                  property="stereo_fly_test",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer"),
     *                                      @OA\Property(property="nombre", type="string"),
     *                                      @OA\Property(property="estado_registro", type="char"),
     *                                  )
     *                              ),
     *                              @OA\Property(
     *                                  type="array",
     *                                  property="circulos",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer"),
     *                                      @OA\Property(property="nombre", type="string"),
     *                                      @OA\Property(property="estado_registro", type="char"),
     *                                  )
     *                              ),
     *                          )
     *                     ),
     *                     @OA\Property(
     *                          type="array",
     *                          property="examen_segmentado",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer"),
     *                              @OA\Property(property="ojo_derecho_id", type="foreignId"),
     *                              @OA\Property(property="ojo_izquierdo_id", type="foreignId"),
     *                              @OA\Property(property="estado_registro", type="char"),
     *                              @OA\Property(
     *                                  type="array",
     *                                  property="ojo_derecho",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer"),
     *                                      @OA\Property(property="parpados", type="string"),
     *                                      @OA\Property(property="conjuntiva", type="string"),
     *                                      @OA\Property(property="cornea", type="string"),
     *                                      @OA\Property(property="camara_anterior", type="string"),
     *                                      @OA\Property(property="iris", type="string"),
     *                                      @OA\Property(property="cristalino", type="string"),
     *                                      @OA\Property(property="refle_pupilares", type="string"),
     *                                      @OA\Property(property="estado_registro", type="char"),
     *                                  )
     *                              ),
     *                              @OA\Property(
     *                                  type="array",
     *                                  property="ojo_izquierdo",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer"),
     *                                      @OA\Property(property="parpados", type="string"),
     *                                      @OA\Property(property="conjuntiva", type="string"),
     *                                      @OA\Property(property="cornea", type="string"),
     *                                      @OA\Property(property="camara_anterior", type="string"),
     *                                      @OA\Property(property="iris", type="string"),
     *                                      @OA\Property(property="cristalino", type="string"),
     *                                      @OA\Property(property="refle_pupilares", type="string"),
     *                                      @OA\Property(property="estado_registro", type="char"),
     *                                  )
     *                              ),
     *                          )
     *                     ),
     *                              example={
     *                                     "id": 1,
     *                                     "clinica_servicio_id": 1,
     *                                     "vision_colores_id": 1,
     *                                     "reconoce_colores": 1,
     *                                     "dificultad_color": 1,
     *                                     "estereopsis_id": 1,
     *                                     "examen_segmentado_id": 1,
     *                                     "estado_registro": "A",
     *                                     "clinica_servicio": {
     *                                         "id": 1,
     *                                         "servicio_id": "",
     *                                         "clinica_id": "1",
     *                                         "nombre": "Servicio SuperPadre",
     *                                         "icono": "",
     *                                         "parent_id": "",
     *                                         "estado_registro": "A"
     *                                     },
     *                                     "vision_colores": {
     *                                         "id": 1,
     *                                         "ojo_derecho": "normal2",
     *                                         "ojo_izquierdo": "normal2",
     *                                         "estado_registro": "A"
     *                                     },
     *                                     "estereopsis": {
     *                                         "id": 1,
     *                                         "stereo_fly_test_id": 3,
     *                                         "circulos_id": 2,
     *                                         "movimiento_ocular_tropias": "normal2",
     *                                         "estado_registro": "A",
     *                                         "stereo_fly_test": {
     *                                             "id": 3,
     *                                             "nombre": "59 MINS",
     *                                             "estado_registro": "A"
     *                                         },
     *                                         "circulos": {
     *                                             "id": 2,
     *                                             "nombre": "2-400 sec.",
     *                                             "estado_registro": "A"
     *                                         }
     *                                     },
     *                                     "examen_segmentado": {
     *                                         "id": 1,
     *                                         "ojo_derecho_id": 2,
     *                                         "ojo_izquierdo_id": 1,
     *                                         "estado_registro": "A",
     *                                         "ojo_derecho": {
     *                                             "id": 2,
     *                                             "parpados": "normal-der",
     *                                             "conjuntiva": "normal-der",
     *                                             "cornea": "normal-der",
     *                                             "camara_anterior": "normal-der",
     *                                             "iris": "normal-der",
     *                                             "cristalino": "normal-der",
     *                                             "refle_pupilares": "normal-der",
     *                                             "estado_registro": "A"
     *                                         },
     *                                         "ojo_izquierdo": {
     *                                             "id": 1,
     *                                             "parpados": "normal-izq",
     *                                             "conjuntiva": "normal-izq",
     *                                             "cornea": "normal-izq",
     *                                             "camara_anterior": "normalizq",
     *                                             "iris": "normal-izq",
     *                                             "cristalino": "normal-izq",
     *                                             "refle_pupilares": "normal-izq",
     *                                             "estado_registro": "A"
     *                                         }
     *                                     }
     *                                 }
     *                )
     *            ),
     *            @OA\Property(type="count",property="size",example="1")
     *        )
     *    ),
     *        @OA\Response(
     *        response=404,
     *        description="invalid",
     *        @OA\JsonContent(
     *            @OA\Property(property="resp", type="string", example="Test no existe")
     *            )
     *        ),
     *         @OA\Response(
     *         response=500,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="No se encuentran Registros...")
     *             )
     *         )
     * )
     */
    public function get(){
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $test = Test::with(['clinica_servicio','vision_colores','estereopsis.stereo_fly_test','estereopsis.circulos','examen_segmentado.ojo_derecho','examen_segmentado.ojo_izquierdo'])->where('estado_registro', 'A')->get(); 
                if(!$test){
                    return response()->json(['error' => 'Test no existe'],404);
                }
                
            }else {
                return response()->json(["error"=>"No tiene accesos (Clínica)..."]);
            }
            return response()->json(["data"=>$test,"size"=>count($test)]);
        } catch (Exception $e) {
            return response()->json(["No se encuentran Registros..." => $e],500);
        }
    }

    /**
     * Crear Datos de Test-Oftalmologia
     * @OA\Post(
     *     path = "/api/oftalmologia/test/create",
     *     summary = "Creando Datos de Test-Oftalmologia",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Test-Oftalmologia"},
     *      @OA\Parameter(description="ojo_derecho",@OA\Schema(type="string"), name="ojo_derecho", in="query", required=false, example="normal"),
     *      @OA\Parameter(description="ojo_izquierdo",@OA\Schema(type="string"), name="ojo_derecho", in="query", required=false, example="normal"),
     *      @OA\Parameter(description="stereo_fly_test_id",@OA\Schema(type="foreignId"), name="stereo_fly_test_id", in="query", required=false, example="3"),
     *      @OA\Parameter(description="circulos_id",@OA\Schema(type="foreignId"), name="circulos_id", in="query", required=false, example="2"),
     *      @OA\Parameter(description="movimiento_ocular_tropias",@OA\Schema(type="string"), name="movimiento_ocular_tropias", in="query", required=false, example="normal"),
     *      @OA\Parameter(description="clinica_servicio_id",@OA\Schema(type="foreignId"), name="clinica_servicio_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="reconoce_colores true(1)/false(0)",@OA\Schema(type="integer"), name="reconoce_colores", in="query", required=false, example=1),
     *      @OA\Parameter(description="dificultad_color true(1)/false(0)",@OA\Schema(type="integer"), name="dificultad_color", in="query", required=false, example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="ojo_derecho", type="string"),
     *                      @OA\Property(property="ojo_izquierdo", type="string"),
     *                      @OA\Property(property="stereo_fly_test_id", type="foreignId"),
     *                      @OA\Property(property="circulos_id", type="foreignId"),
     *                      @OA\Property(property="movimiento_ocular_tropias", type="string"),
     *                      @OA\Property(
     *                        type="array",
     *                        property="segmentado_izq",
     *                        @OA\Items(
     *                            type="object",
     *                            @OA\Property(property="parpados", type="string"),
     *                            @OA\Property(property="conjuntiva", type="string"),
     *                            @OA\Property(property="cornea", type="string"),
     *                            @OA\Property(property="camara_anterior", type="string"),
     *                            @OA\Property(property="iris", type="string"),
     *                            @OA\Property(property="cristalino", type="string"),
     *                            @OA\Property(property="refle_pupilares", type="string"),
     *                        )
     *                     ),
     *                      @OA\Property(
     *                        type="array",
     *                        property="segmentado_der",
     *                        @OA\Items(
     *                            type="object",
     *                            @OA\Property(property="parpados", type="string"),
     *                            @OA\Property(property="conjuntiva", type="string"),
     *                            @OA\Property(property="cornea", type="string"),
     *                            @OA\Property(property="camara_anterior", type="string"),
     *                            @OA\Property(property="iris", type="string"),
     *                            @OA\Property(property="cristalino", type="string"),
     *                            @OA\Property(property="refle_pupilares", type="string"),
     *                        )
     *                     ),
     *                     @OA\Property(property="clinica_servicio_id", type="foreignId"),
     *                     @OA\Property(property="reconoce_colores", type="foreignId"),
     *                     @OA\Property(property="dificultad_color", type="foreignId"),
     *                  ),
     *                   example={
     *                           "ojo_derecho": "normal",
     *                           "ojo_izquierdo": "normal",
     *                           "stereo_fly_test_id": 3,
     *                           "circulos_id": 2,
     *                           "movimiento_ocular_tropias": "normal",
     *                           "segmentado_izq": 
     *                               {
     *                                   "parpados": "normal-izq",
     *                                   "conjuntiva": "normal-izq",
     *                                   "cornea": "normal-izq",
     *                                   "camara_anterior": "normal-izq",
     *                                   "iris": "normal-izq",
     *                                   "cristalino": "normal-1",
     *                                   "refle_pupilares": "normal-izq"
     *                               },
     *                           "segmentado_der": 
     *                               {
     *                                   "parpados": "normal-der",
     *                                   "conjuntiva": "normal-der",
     *                                   "cornea": "normal-der",
     *                                   "camara_anterior": "normal-der",
     *                                   "iris": "normal-der",
     *                                   "cristalino": "normal-der",
     *                                   "refle_pupilares": "normal-der"
     *                               },
     *                           "clinica_servicio_id": "1",
     *                           "reconoce_colores": "1",
     *                           "dificultad_color": "1"
     *                       }
     *              )
     *   
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Test creado correctamente")
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
     *             @OA\Property(property="error", type="string", example="error: Test no se ha creado...")
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
            if($clinica)
            {

                if(strlen($request->stereo_fly_test_id) == 0) return response()->json(['resp' => 'No ingresaste el id de stereo_fly_test'], 404);
                if(strlen($request->circulos_id) == 0) return response()->json(['resp' => 'No ingresaste el id de circulos'], 404);

                $estereopsis_ster = StereoFlyTest::where('estado_registro','A')->find($request->stereo_fly_test_id);
                if(!$estereopsis_ster) return response()->json(['error' => 'El id StereoFlyTest no existe'], 404);
                
                $estereopsis_circ = StereoFlyTest::where('estado_registro','A')->find($request->circulos_id);
                if(!$estereopsis_circ) return response()->json(['error' => 'El id Circulos no existe'], 404);

                
                $vision_colores = VisionColores::create([
                    'ojo_derecho'=>$request->ojo_derecho,
                    'ojo_izquierdo'=>$request->ojo_izquierdo,
                ]);
                $estereopsis = Estereopsis::create([
                    'stereo_fly_test_id'=>$request->stereo_fly_test_id,
                    'circulos_id'=>$request->circulos_id,
                    'movimiento_ocular_tropias'=>$request->movimiento_ocular_tropias
                ]);

                $segmentado_izqu = $request->segmentado_izq;
                // return response()->json($segmentado_izqu);
                $segmentado_izq = Segmento::create([
                    'parpados'=>$segmentado_izqu['parpados'],
                    'conjuntiva'=>$segmentado_izqu['conjuntiva'],
                    'cornea'=>$segmentado_izqu['cornea'],
                    'camara_anterior'=>$segmentado_izqu['camara_anterior'],
                    'iris'=>$segmentado_izqu['iris'],
                    'cristalino'=>$segmentado_izqu['cristalino'],
                    'refle_pupilares'=>$segmentado_izqu['refle_pupilares']
                ]);
                
                
                $segmentado_dere = $request->segmentado_der;
                $segmentado_der = Segmento::create([
                    'parpados'=>$segmentado_dere['parpados'],
                    'conjuntiva'=>$segmentado_dere['conjuntiva'],
                    'cornea'=>$segmentado_dere['cornea'],
                    'camara_anterior'=>$segmentado_dere['camara_anterior'],
                    'iris'=>$segmentado_dere['iris'],
                    'cristalino'=>$segmentado_dere['cristalino'],
                    'refle_pupilares'=>$segmentado_dere['refle_pupilares']
                ]);

                $examen_segmentado = ExamenSegmentado::create([
                    'ojo_izquierdo_id'=>$segmentado_izq->id,
                    'ojo_derecho_id'=>$segmentado_der->id
                    
                ]);
                Test::create([
                    'clinica_servicio_id' => $request->clinica_servicio_id,
                    'vision_colores_id' => $vision_colores->id,
                    'reconoce_colores' => $request->reconoce_colores,
                    'dificultad_color' => $request->dificultad_color,
                    'estereopsis_id' => $estereopsis->id,
                    'examen_segmentado_id' => $examen_segmentado->id
                ]);
                
                
                DB::commit();
            }else{
                return response()->json(["error"=>"No tiene accesos (Clínica)..."]);
            }
            return response()->json(["resp" => "Test creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            // return response()->json(["error: Test no se ha creado..." => $e],501);
            return response()->json(["Error"=> "".$e],501);
        }
    }

    /**
     * Modificar Datos de Test-Oftalmologia
     * @OA\Put(
     *     path = "/api/oftalmologia/test/update/{idTest}",
     *     summary = "Actualizando Datos de DiagnosticoFinal",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Test-Oftalmologia"},
     *      @OA\Parameter(in="path",name="idTest", required=true, @OA\Schema(type="integer")),
     *      @OA\Parameter(description="ojo_derecho",@OA\Schema(type="string"), name="ojo_derecho", in="query", required=false, example="normal"),
     *      @OA\Parameter(description="ojo_izquierdo",@OA\Schema(type="string"), name="ojo_derecho", in="query", required=false, example="normal"),
     *      @OA\Parameter(description="stereo_fly_test_id",@OA\Schema(type="foreignId"), name="stereo_fly_test_id", in="query", required=false, example="3"),
     *      @OA\Parameter(description="circulos_id",@OA\Schema(type="foreignId"), name="circulos_id", in="query", required=false, example="2"),
     *      @OA\Parameter(description="movimiento_ocular_tropias",@OA\Schema(type="string"), name="movimiento_ocular_tropias", in="query", required=false, example="normal"),
     *      @OA\Parameter(description="clinica_servicio_id",@OA\Schema(type="foreignId"), name="clinica_servicio_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="reconoce_colores",@OA\Schema(type="integer"), name="reconoce_colores", in="query", required=false, example="1"),
     *      @OA\Parameter(description="dificultad_color",@OA\Schema(type="integer"), name="dificultad_color", in="query", required=false, example="1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="ojo_derecho", type="string"),
     *                      @OA\Property(property="ojo_izquierdo", type="string"),
     *                      @OA\Property(property="stereo_fly_test_id", type="foreignId"),
     *                      @OA\Property(property="circulos_id", type="foreignId"),
     *                      @OA\Property(property="movimiento_ocular_tropias", type="string"),
     *                      @OA\Property(
     *                        type="array",
     *                        property="segmentado_izq",
     *                        @OA\Items(
     *                            type="object",
     *                            @OA\Property(property="parpados", type="string"),
     *                            @OA\Property(property="conjuntiva", type="string"),
     *                            @OA\Property(property="cornea", type="string"),
     *                            @OA\Property(property="camara_anterior", type="string"),
     *                            @OA\Property(property="iris", type="string"),
     *                            @OA\Property(property="cristalino", type="string"),
     *                            @OA\Property(property="refle_pupilares", type="string"),
     *                        )
     *                     ),
     *                      @OA\Property(
     *                        type="array",
     *                        property="segmentado_der",
     *                        @OA\Items(
     *                            type="object",
     *                            @OA\Property(property="parpados", type="string"),
     *                            @OA\Property(property="conjuntiva", type="string"),
     *                            @OA\Property(property="cornea", type="string"),
     *                            @OA\Property(property="camara_anterior", type="string"),
     *                            @OA\Property(property="iris", type="string"),
     *                            @OA\Property(property="cristalino", type="string"),
     *                            @OA\Property(property="refle_pupilares", type="string"),
     *                        )
     *                     ),
     *                     @OA\Property(property="clinica_servicio_id", type="foreignId"),
     *                     @OA\Property(property="reconoce_colores", type="foreignId"),
     *                     @OA\Property(property="dificultad_color", type="foreignId"),
     *                  ),
     *                   example={
     *                           "ojo_derecho": "normal",
     *                           "ojo_izquierdo": "normal",
     *                           "stereo_fly_test_id": 3,
     *                           "circulos_id": 2,
     *                           "movimiento_ocular_tropias": "normal",
     *                           "segmentado_izq": 
     *                               {
     *                                   "parpados": "normal-izq",
     *                                   "conjuntiva": "normal-izq",
     *                                   "cornea": "normal-izq",
     *                                   "camara_anterior": "normal-izq",
     *                                   "iris": "normal-izq",
     *                                   "cristalino": "normal-1",
     *                                   "refle_pupilares": "normal-izq"
     *                               },
     *                           "segmentado_der": 
     *                               {
     *                                   "parpados": "normal-der",
     *                                   "conjuntiva": "normal-der",
     *                                   "cornea": "normal-der",
     *                                   "camara_anterior": "normal-der",
     *                                   "iris": "normal-der",
     *                                   "cristalino": "normal-der",
     *                                   "refle_pupilares": "normal-der"
     *                               },
     *                           "clinica_servicio_id": "1",
     *                           "reconoce_colores": "1",
     *                           "dificultad_color": "1"
     *                       }
     *              )
     *   
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Test actualizado correctamente")
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
     *             @OA\Property(property="error", type="string", example="error: Test no se ha actualizado...")
     *             )
     *         )
     * )
     */

    public function update(Request $request, $idTest)                                                         //accesos aqui tbm?
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $test = Test::where('estado_registro','A')->find($idTest);

                if(strlen($request->stereo_fly_test_id) == 0) return response()->json(['resp' => 'No ingresaste el id de stereo_fly_test'], 404);
                if(strlen($request->circulos_id) == 0) return response()->json(['resp' => 'No ingresaste el id de circulos'], 404);

                $estereopsis_ster = StereoFlyTest::where('estado_registro','A')->find($request->stereo_fly_test_id);
                if(!$estereopsis_ster) return response()->json(['error' => 'El id StereoFlyTest no existe'], 404);
                
                $estereopsis_circ = StereoFlyTest::where('estado_registro','A')->find($request->circulos_id);
                if(!$estereopsis_circ) return response()->json(['error' => 'El id Circulos no existe'], 404);

                

                $vision_colores = VisionColores::with('test')->where('estado_registro','A')->where('id',$test->vision_colores_id)->first();
                $estereopsis = Estereopsis::with('test')->where('estado_registro','A')->where('id',$test->estereopsis_id)->first();
                $examen_segmentado = ExamenSegmentado::with('test')->where('estado_registro','A')->where('id',$test->examen_segmentado_id)->first();


                $estereopsis_ster = Estereopsis::where('estado_registro','A')->find($request->stereo_fly_test_id);
                if(!$estereopsis_ster) return response()->json(['error' => 'El id StereoFlyTest no existe'], 404);
                
                $estereopsis_circ = Estereopsis::where('estado_registro','A')->find($request->circulos_id);
                if(!$estereopsis_circ) return response()->json(['error' => 'El id Circulos no existe'], 404);


                $vision_colores->fill([
                    'ojo_derecho'=>$request->ojo_derecho,
                    'ojo_izquierdo'=>$request->ojo_izquierdo,
                ])->save();

                
                $estereopsis->fill([
                    'stereo_fly_test_id'=>$request->stereo_fly_test_id,
                    'circulos_id'=>$request->circulos_id,
                    'movimiento_ocular_tropias'=>$request->movimiento_ocular_tropias
                ])->save();

                
                
                
                $segmentado_izqu = $request->segmentado_izq;
                // return response()->json($segmentado_izqu);
                $segmentado_izq = Segmento::create([
                    'parpados'=>$segmentado_izqu['parpados'],
                    'conjuntiva'=>$segmentado_izqu['conjuntiva'],
                    'cornea'=>$segmentado_izqu['cornea'],
                    'camara_anterior'=>$segmentado_izqu['camara_anterior'],
                    'iris'=>$segmentado_izqu['iris'],
                    'cristalino'=>$segmentado_izqu['cristalino'],
                    'refle_pupilares'=>$segmentado_izqu['refle_pupilares']
                ]);
                
                
                $segmentado_dere = $request->segmentado_der;
                $segmentado_der = Segmento::create([
                    'parpados'=>$segmentado_dere['parpados'],
                    'conjuntiva'=>$segmentado_dere['conjuntiva'],
                    'cornea'=>$segmentado_dere['cornea'],
                    'camara_anterior'=>$segmentado_dere['camara_anterior'],
                    'iris'=>$segmentado_dere['iris'],
                    'cristalino'=>$segmentado_dere['cristalino'],
                    'refle_pupilares'=>$segmentado_dere['refle_pupilares']
                ]);

                $examen_segmentado->fill([
                        'ojo_derecho_id'=>$segmentado_der->id,
                        'ojo_izquierdo_id'=>$segmentado_izq->id
                    ])->save();


                $test->fill([
                    'clinica_servicio_id' => $request->clinica_servicio_id,
                    'vision_colores_id' => $vision_colores->id,
                    'reconoce_colores' => $request->reconoce_colores,
                    'dificultad_color' => $request->dificultad_color,
                    'estereopsis_id' => $estereopsis->id,
                    'examen_segmentado_id' => $examen_segmentado->id
                ])->save();
                
                
                DB::commit();
            }else{
                return response()->json(["error"=>"No tiene accesos (Clínica)..."]);
            }
            return response()->json(["resp" => "Test actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            // return response()->json(["Error: Test no se ha actualizadp..." => $e]);
            return response()->json(["Error"=> "".$e],501);
        }
    }

    /**
     * Delete Datos de Test-Oftalmologia
     * @OA\Delete (
     *     path="/api/oftalmologia/test/delete/{idTest}",
     *     summary = "Inactivando Datos de Test-Oftalmologia",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Test-Oftalmologia"},
     *     @OA\Parameter(
     *         in="path",
     *         name="idTest",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Test inactivida correctamente")
     *         )
     *     ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Test ya inactivado")
     *             )
     *         )
     * )
     */

    public function delete($idTest)
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $test = Test::find($idTest);
                if ($test) {
                    if (!$test->where('estado_registro','A')->first()) return response()->json(['error' => 'Test ya inactivado'],404);
                }else if(!$test) return response()->json(['error' => 'Test no existe'],404);
                

                $vision_colores = VisionColores::with('test')->where('estado_registro','A')->where('id',$test->vision_colores_id)->first();
                $estereopsis = Estereopsis::with('test')->where('estado_registro','A')->where('id',$test->estereopsis_id)->first();
                $examen_segmentado = ExamenSegmentado::with('test')->where('estado_registro','A')->where('id',$test->examen_segmentado_id)->first();
                $segmentado_izq = Segmento::where('estado_registro','A')->where('id',$examen_segmentado->ojo_izquierdo_id)->first();
                $segmentado_der = Segmento::where('estado_registro','A')->where('id',$examen_segmentado->ojo_derecho_id)->first();

                $vision_colores->fill([
                    'estado_registro' => 'I',
                ])->save();

                $estereopsis->fill([
                    'estado_registro' => 'I',
                ])->save();

                $segmentado_der->fill([
                    'estado_registro' => 'I',
                ])->save();

                $segmentado_izq->fill([
                    'estado_registro' => 'I',
                ])->save();

                $examen_segmentado->fill([
                    'estado_registro' => 'I',
                ])->save();

                $test->fill([
                    'estado_registro' => 'I',
                ])->save();
                
                DB::commit();
            }else{
                return response()->json(["error"=>"No tiene accesos (Clínica)..."]);
            }
            return response()->json(["resp" => "Test inactivado correctamente"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }


    
    public function activar($idTest)
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $test = Test::find($idTest);
                if ($test) 
                    if (!$test->where('estado_registro','I')->first()) return response()->json(['error' => 'Test ya activado'],404);
                else if(!$test) return response()->json(['error' => 'Test no existe'],404);
                

                $vision_colores = VisionColores::with('test')->where('estado_registro','I')->where('id',$test->vision_colores_id)->first();
                $estereopsis = Estereopsis::with('test')->where('estado_registro','I')->where('id',$test->estereopsis_id)->first();
                $examen_segmentado = ExamenSegmentado::with('test')->where('estado_registro','I')->where('id',$test->examen_segmentado_id)->first();
                $segmentado_izq = Segmento::where('estado_registro','I')->where('id',$examen_segmentado->ojo_izquierdo_id)->first();
                $segmentado_der = Segmento::where('estado_registro','I')->where('id',$examen_segmentado->ojo_derecho_id)->first();

                $vision_colores->fill([
                    'estado_registro' => 'A',
                ])->save();

                $estereopsis->fill([
                    'estado_registro' => 'A',
                ])->save();

                $segmentado_der->fill([
                    'estado_registro' => 'A',
                ])->save();

                $segmentado_izq->fill([
                    'estado_registro' => 'A',
                ])->save();

                $examen_segmentado->fill([
                    'estado_registro' => 'A',
                ])->save();

                $test->fill([
                    'estado_registro' => 'A',
                ])->save();
                
                DB::commit();
            }else{
                return response()->json(["error"=>"No tiene accesos (Clínica)..."]);
            }
            return response()->json(["resp" => "Test activado correctamente"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }

    /**
     * Mostrar Datos de StereoFlyTest
     * @OA\Get (
     *     path="/api/oftalmologia/test/estereopsis/stereo_fly_test/get",
     *     summary="Mostar Datos de StereoFlyTest",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Test-Oftalmologia"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example="1"),
     *                             @OA\Property(property="nombre", type="string", example="normal"),
     *                             @OA\Property(property="estado_registro", type="char", example="A"), 
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="estereopsis",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="stereo_fly_test_id", type="foreignId", example="1"),
     *                                      @OA\Property(property="circulos_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="movimiento_ocular_tropias", type="foreignId", example="normal"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                                  )
     *                             ),
     *                        )
     *              
     *          ),
     *          @OA\Property(type="count", property="size", example="1")
     *     )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="stereo_fly_test no existe")
     *             )
     *         )
     *  )
     */

    public function get_stereo_fly_test(){
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $test = StereoFlyTest::with('estereopsis')->where('estado_registro', 'A')->get(); 
                if(!$test){
                    return response()->json(['error' => 'stereo_fly_test no existe'],404);
                }
                
            }else {
                return response()->json(["error"=>"No tiene accesos (Clínica)..."]);
            }
            return response()->json(["data"=>$test,"size"=>count($test)]);
        } catch (Exception $e) {
            return response()->json(["No se encuentran Registros..." => $e],500);
        }
    }


    /**
     * Mostrar Datos de Circulos
     * @OA\Get (
     *     path="/api/oftalmologia/test/estereopsis/circulos/get",
     *     summary="Mostar Datos de Circulos",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Test-Oftalmologia"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                     @OA\Items(
     *                         type="object",
     *                             @OA\Property(property="id", type="integer", example="2"),
     *                             @OA\Property(property="nombre", type="string", example="2-400 sec."),
     *                             @OA\Property(property="estado_registro", type="char", example="A"), 
     *                             @OA\Property(
     *                                  type="array",
     *                                  property="estereopsis",
     *                                  @OA\Items(
     *                                      type="object",
     *                                      @OA\Property(property="id", type="integer", example="1"),
     *                                      @OA\Property(property="stereo_fly_test_id", type="foreignId", example="1"),
     *                                      @OA\Property(property="circulos_id", type="foreignId", example="2"),
     *                                      @OA\Property(property="movimiento_ocular_tropias", type="foreignId", example="normal"),
     *                                      @OA\Property(property="estado_registro", type="char", example="A")
     *                                  )
     *                             ),
     *                        )
     *              
     *          ),
     *          @OA\Property(type="count", property="size", example="1")
     *     )
     *      ),
     *         @OA\Response(
     *         response=404,
     *         description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Circulos no existe")
     *             )
     *         )
     *  )
     */
    public function get_circulos(){
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $test = Circulos::with('estereopsis')->where('estado_registro', 'A')->get(); 
                if(!$test){
                    return response()->json(['error' => 'Circulos no existe'],404);
                }
                
            }else {
                return response()->json(["error"=>"No tiene accesos (Clínica)..."]);
            }
            return response()->json(["data"=>$test,"size"=>count($test)]);
        } catch (Exception $e) {
            return response()->json(["No se encuentran Registros..." => $e],500);
        }
    }
}

