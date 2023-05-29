<?php

namespace App\Http\Controllers\Psicologia;

use App\Models\EvaluacionEmocional;
use App\Models\EvaluacionOrganica;
use App\Models\EvaluacionPsicopatologica;
use Illuminate\Http\Request;
use App\Models\Preguntas;
use App\Models\SanoMentalmente;
use App\Models\TestFatiga;
use App\Models\TestSomnolenda;
use App\Models\TipoEstres;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\User;
use Carbon\Exceptions\Exception as ExceptionsException;

class PreguntasController extends Controller
{
    /**
     * Get 
     * @OA\Get (
     *     path="/api/psicologia/preguntas/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="number",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="clinica_servicio_id",
     *                         type="foreignId",
     *                         example=null
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_psicopatologica_id",
     *                         type="foreignId",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_organica_id",
     *                         type="foreignId",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_emocional_id",
     *                         type="foreignId",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="sano_mentalmente_id",
     *                         type="foreignId",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="tipo_estres_id",
     *                         type="foreignId",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="test_somnolenda_id",
     *                         type="foreignId",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="test_fatiga_id",
     *                         type="foreignId",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="char",
     *                         example="A"
     *                     ),
     *                     @OA\Property(
     *                         type="array",
     *                         property="evaluaciones_psicopatologicas",
     *                         @OA\Items(
     *                               type="object",
     *                               @OA\Property(
     *                                    property="id",
     *                                    type="number",
     *                                    example="1"
     *                                ),
     *                               @OA\Property(
     *                                    property="resultado",
     *                                    type="string",
     *                                    example="Si"
     *                                ),
     *                               @OA\Property(
     *                                    property="estado_registro",
     *                                    type="char",
     *                                    example="A"
     *                                ),
     *                          )
     *                      ),
     *                      @OA\Property(
     *                         type="array",
     *                         property="evaluacion_organica",
     *                         @OA\Items(
     *                               type="object",
     *                               @OA\Property(
     *                                    property="id",
     *                                    type="number",
     *                                    example="1"
     *                                ),
     *                               @OA\Property(
     *                                    property="resultado",
     *                                    type="string",
     *                                    example="Si"
     *                                ),
     *                               @OA\Property(
     *                                    property="estado_registro",
     *                                    type="char",
     *                                    example="A"
     *                                ),
     *                          )
     *                      ),
     *                      @OA\Property(
     *                         type="array",
     *                         property="evaluacion_emocional",
     *                         @OA\Items(
     *                               type="object",
     *                               @OA\Property(
     *                                    property="id",
     *                                    type="number",
     *                                    example="1"
     *                                ),
     *                               @OA\Property(
     *                                    property="resultado",
     *                                    type="string",
     *                                    example="Si"
     *                                ),
     *                               @OA\Property(
     *                                    property="estado_registro",
     *                                    type="char",
     *                                    example="A"
     *                                ),
     *                          )
     *                      ),
     *                      @OA\Property(
     *                         type="array",
     *                         property="sano_mentalmente",
     *                         @OA\Items(
     *                               type="object",
     *                               @OA\Property(
     *                                    property="id",
     *                                    type="number",
     *                                    example="1"
     *                                ),
     *                               @OA\Property(
     *                                    property="resultado",
     *                                    type="string",
     *                                    example="Si"
     *                                ),
     *                               @OA\Property(
     *                                    property="estado_registro",
     *                                    type="char",
     *                                    example="A"
     *                                ),
     *                          )
     *                      ),
     *                      @OA\Property(
     *                         type="array",
     *                         property="tipo_estres",
     *                         @OA\Items(
     *                               type="object",
     *                               @OA\Property(
     *                                    property="id",
     *                                    type="number",
     *                                    example="1"
     *                                ),
     *                               @OA\Property(
     *                                    property="resultado",
     *                                    type="string",
     *                                    example="Normal"
     *                                ),
     *                               @OA\Property(
     *                                    property="estado_registro",
     *                                    type="char",
     *                                    example="A"
     *                                ),
     *                          )
     *                      ),
     *                      @OA\Property(
     *                         type="array",
     *                         property="test_somnolenda",
     *                         @OA\Items(
     *                               type="object",
     *                               @OA\Property(
     *                                    property="id",
     *                                    type="number",
     *                                    example="1"
     *                                ),
     *                               @OA\Property(
     *                                    property="resultado",
     *                                    type="string",
     *                                    example="Normal"
     *                                ),
     *                               @OA\Property(
     *                                    property="estado_registro",
     *                                    type="char",
     *                                    example="A"
     *                                ),
     *                          )
     *                      ),
     *                      @OA\Property(
     *                         type="array",
     *                         property="test_fatiga",
     *                         @OA\Items(
     *                               type="object",
     *                               @OA\Property(
     *                                    property="id",
     *                                    type="number",
     *                                    example="1"
     *                                ),
     *                               @OA\Property(
     *                                    property="resultado",
     *                                    type="string",
     *                                    example="Normal"
     *                                ),
     *                               @OA\Property(
     *                                    property="estado_registro",
     *                                    type="char",
     *                                    example="A"
     *                                ),
     *                          )
     *                      )
     *                 )
     *             ),
     *               @OA\Property(
     *               property="size",
     *               type="count",
     *               example="1"
     *             )
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function get()
    {
        try{
            $datos = Preguntas::with('clinica_servicio','evaluaciones_psicopatologicas','evaluacion_organica','evaluacion_emocional','sano_mentalmente','tipo_estres','test_somnolenda','test_fatiga')->where('estado_registro', 'A')->get();
            /*
            evaluaciones_psicopatologicas= 1  2
            evaluacion_organica = 1  2
            evaluacion_emocional = 1  2
            sano_mentalmente = 1  2
            tipo_estres = 1 2 3
            test_somnolenda = 1 2 3
            test_fatiga = 1 2 3 
            */
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * Create
     * @OA\Post (
     *     path="/api/psicologia/preguntas/create",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Clinica Servicio'",
     *          @OA\Schema(type="integer"),
     *          name="clinica_servicio_id",
     *          in="query",
     *          required= false,
     *          example=null
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Evaluacion Psicopatologica'",
     *          @OA\Schema(type="integer"),
     *          name="evaluacion_psicopatologica_id",
     *          in="query",
     *          required= true,
     *          example=1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Evaluacion Organica'",
     *          @OA\Schema(type="integer"),
     *          name="evaluacion_organica_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Evaluacion Emocional'",
     *          @OA\Schema(type="integer"),
     *          name="evaluacion_emocional_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Sano Mentalmente'",
     *          @OA\Schema(type="integer"),
     *          name="sano_mentalmente_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Tipo Estres'",
     *          @OA\Schema(type="integer"),
     *          name="tipo_estres_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Test Somnolenda'",
     *          @OA\Schema(type="integer"),
     *          name="test_somnolenda_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Test Fatiga'",
     *          @OA\Schema(type="integer"),
     *          name="test_fatiga_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                         property="clinica_servicio_id",
     *                         type="foreignId",
     *                         example= null
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_psicopatologica_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_organica_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_emocional_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                         property="sano_mentalmente_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                        property="tipo_estres_id",
     *                        type="foreignId",
     *                        example= 1
     *                     ),
     *                     @OA\Property(
     *                        property="test_somnolenda_id",
     *                        type="foreignId",
     *                        example= 1
     *                     ),
     *                     @OA\Property(
     *                        property="test_fatiga_id",
     *                        type="foreignId",
     *                        example= 1
     *                     ),
     *                 ),
     *                 example={
     *                     "clinica_servicio_id": 0,
     *                     "evaluacion_psicopatologica_id":"example anamnesis",
     *                     "evaluacion_organica_id":2.5,
     *                     "evaluacion_emocional_id":2.5,
     *                     "sano_mentalmente_id":0,
     *                     "tipo_estres_id":"example diagnostico_nutricional",
     *                     "test_somnolenda_id":2.5,
     *                     "test_fatiga_id":2.5,
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();                                                                   
            if($clinica)
            {
            if (strlen($request->evaluacion_psicopatologica_id) == 0) return response()->json(['resp' => 'No ingresaste el id de evaluacion_psicopatologica'], 404);
            if (strlen($request->evaluacion_organica_id) == 0) return response()->json(['resp' => 'No ingresaste el id de evaluacion_organica'], 404);
            if (strlen($request->evaluacion_emocional_id) == 0) return response()->json(['resp' => 'No ingresaste el id de evaluacion_emocional'], 404);
            if (strlen($request->sano_mentalmente_id) == 0) return response()->json(['resp' => 'No ingresaste el id de sano_mentalmente'], 404);
            if (strlen($request->tipo_estres_id) == 0) return response()->json(['resp' => 'No ingresaste el id de tipo_estres'], 404);
            if (strlen($request->test_somnolenda_id) == 0) return response()->json(['resp' => 'No ingresaste el id de test_somnolenda'], 404);
            if (strlen($request->test_fatiga_id) == 0) return response()->json(['resp' => 'No ingresaste el id de test_fatiga'], 404);
            if (!EvaluacionPsicopatologica::where('estado_registro', 'A')->find($request->evaluacion_psicopatologica_id)) return response()->json(['error' => 'El id Evaluacion Psicopatologica no existe'], 404);
            if (!EvaluacionOrganica::where('estado_registro', 'A')->find($request->evaluacion_organica_id)) return response()->json(['error' => 'El id Evaluacion Organica no existe'], 404);
            if (!EvaluacionEmocional::where('estado_registro', 'A')->find($request->evaluacion_emocional_id)) return response()->json(['error' => 'El id Evaluacion Emocional no existe'], 404);
            if (!SanoMentalmente::where('estado_registro', 'A')->find($request->sano_mentalmente_id)) return response()->json(['error' => 'El id Sano Mentalmente no existe'], 404);
            if (!TipoEstres::where('estado_registro', 'A')->find($request->tipo_estres_id)) return response()->json(['error' => 'El id Tipo Estres no existe'], 404);
            if (!TestSomnolenda::where('estado_registro', 'A')->find($request->test_somnolenda_id)) return response()->json(['error' => 'El id Test Somnolenda no existe'], 404);
            if (!TestFatiga::where('estado_registro', 'A')->find($request->test_fatiga_id)) return response()->json(['error' => 'El id Test Fatiga no existe'], 404);
                Preguntas::create([
                    'clinica_servicio_id' => $request->clinica_servicio_id,
                    'evaluacion_psicopatologica_id' => $request->evaluacion_psicopatologica_id,
                    'evaluacion_organica_id' => $request->evaluacion_organica_id,
                    'evaluacion_emocional_id' => $request->evaluacion_emocional_id,
                    'sano_mentalmente_id' => $request->sano_mentalmente_id,
                    'tipo_estres_id' => $request->tipo_estres_id,
                    'test_somnolenda_id' => $request->test_somnolenda_id,
                    'test_fatiga_id' => $request->test_fatiga_id,
                ]);
                
        }else{
            return response()->json(["Error"=>"No tiene accesos..."]);
        }
        DB::commit();
            return response()->json(["resp" => "Dato creado correctamente"]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato no se ha creado" => $e]);
        }
        
    }
    /**
     * Update
     * @OA\Put (
     *     path="/api/psicologia/preguntas/update/{id}",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Clinica Servicio'",
     *          @OA\Schema(type="integer"),
     *          name="clinica_servicio_id",
     *          in="query",
     *          required= false,
     *          example= null
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Evaluacion Psicopatologica'",
     *          @OA\Schema(type="integer"),
     *          name="evaluacion_psicopatologica_id",
     *          in="query",
     *          required= true,
     *          example=1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Evaluacion Organica'",
     *          @OA\Schema(type="integer"),
     *          name="evaluacion_organica_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Evaluacion Emocional'",
     *          @OA\Schema(type="integer"),
     *          name="evaluacion_emocional_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Sano Mentalmente'",
     *          @OA\Schema(type="integer"),
     *          name="sano_mentalmente_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Tipo Estres'",
     *          @OA\Schema(type="integer"),
     *          name="tipo_estres_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Test Somnolenda'",
     *          @OA\Schema(type="integer"),
     *          name="test_somnolenda_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *      @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Test Fatiga'",
     *          @OA\Schema(type="integer"),
     *          name="test_fatiga_id",
     *          in="query",
     *          required= true,
     *          example= 1
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                         property="clinica_servicio_id",
     *                         type="foreignId",
     *                         example= null
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_psicopatologica_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_organica_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                         property="evaluacion_emocional_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                         property="sano_mentalmente_id",
     *                         type="foreignId",
     *                         example= 1
     *                     ),
     *                     @OA\Property(
     *                        property="tipo_estres_id",
     *                        type="foreignId",
     *                        example= 1
     *                     ),
     *                     @OA\Property(
     *                        property="test_somnolenda_id",
     *                        type="foreignId",
     *                        example= 1
     *                     ),
     *                     @OA\Property(
     *                        property="test_fatiga_id",
     *                        type="foreignId",
     *                        example= 1
     *                     ),
     *                 ),
     *                 example={
     *                     "clinica_servicio_id": null,
     *                     "evaluacion_psicopatologica_id":"example anamnesis",
     *                     "evaluacion_organica_id":2.5,
     *                     "evaluacion_emocional_id":2.5,
     *                     "sano_mentalmente_id":0,
     *                     "tipo_estres_id":"example diagnostico_nutricional",
     *                     "test_somnolenda_id":2.5,
     *                     "test_fatiga_id":2.5,
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function update(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();                                                                   // usuario empresa tambien?
            if($clinica)
            {
            $datos = Preguntas::where('estado_registro', 'A')->find($id);
            $datos->fill([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'evaluacion_psicopatologica_id' => $request->evaluacion_psicopatologica_id,
                'evaluacion_organica_id' => $request->evaluacion_organica_id,
                'evaluacion_emocional_id' => $request->evaluacion_emocional_id,
                'sano_mentalmente_id' => $request->sano_mentalmente_id,
                'tipo_estres_id' => $request->tipo_estres_id,
                'test_somnolenda_id' => $request->test_somnolenda_id,
                'test_fatiga_id' => $request->test_fatiga_id,
            ])->save();
            DB::commit();
        }else{
            return response()->json(["Error"=>"No tiene accesos..."]);
        }
            return response()->json(["resp" => "Datos actualizado correctamente"]);
        } catch (ExceptionsException $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * Delete
     * @OA\Delete (
     *     path="/api/psicologia/preguntas/delete/{id}",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="delete todo success")
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {            
            $datos = Preguntas::where('estado_registro', 'A')->find($id);
            if(!$datos){
                return response()->json(["resp"=>"Usuario ya Inactivado"]);
            }
            $datos->fill([
                'estado_registro' => 'I',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Dato inactivo correctamente"]);
        } catch (ExceptionsException $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * Reintegrar
     * @OA\Put (
     *     path="/api/psicologia/preguntas/reintegrar/{id}",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="active todo success")
     *         )
     *     ),
     *          @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="ERROR"),
     *              )
     *          )
     * )
     */
    public function reintegrar($id)
    {
        DB::beginTransaction();
        try {            
            $datos = Preguntas::where('estado_registro', 'I')->find($id);
            if(!$datos){
                return response()->json(["resp"=>"Registro ya ha sido Activado"]);
            }
            $datos->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Registro Activado correctamente"]);
        } catch (ExceptionsException $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * EvaluacionPsicopatologicaGet
     * @OA\Get (
     *     path="/api/psicologia/preguntas/Ep/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="integer",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="resultado",
     *                         type="string",
     *                         example="Si"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="size",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function getEp()
    {
        try{
            $datos = EvaluacionPsicopatologica::where('estado_registro', 'A')->get();
            if (!$datos)return response()->json(["No hay registros activos"]);
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * EvaluacionOrganicaGet
     * @OA\Get (
     *     path="/api/psicologia/preguntas/Eo/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="integer",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="resultado",
     *                         type="string",
     *                         example="Si"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="size",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function getEo()
    {
        try{
            $datos = EvaluacionOrganica::where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * EvaluacionEmocionalGet
     * @OA\Get (
     *     path="/api/psicologia/preguntas/Ee/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="integer",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="resultado",
     *                         type="string",
     *                         example="Si"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="size",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function getEe()
    {
        try{
            $datos = EvaluacionEmocional::where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * SanoMentalmenteGet
     * @OA\Get (
     *     path="/api/psicologia/preguntas/Sm/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="integer",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="resultado",
     *                         type="string",
     *                         example="Si"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="size",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function getSm()
    {
        try{
            $datos = SanoMentalmente::where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * TipoEstresGet
     * @OA\Get (
     *     path="/api/psicologia/preguntas/Te/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="integer",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="resultado",
     *                         type="string",
     *                         example="Normal"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="size",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function getTe()
    {
        try{
            $datos = TipoEstres::where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * TestSomnolendaGet
     * @OA\Get (
     *     path="/api/psicologia/preguntas/Ts/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="integer",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="resultado",
     *                         type="string",
     *                         example="Normal"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="size",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function getTs()
    {
        try{
            $datos = TestSomnolenda::where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * TestFatigaGet
     * @OA\Get (
     *     path="/api/psicologia/preguntas/Tf/get",
     *     tags={"Psicologia-Preguntas"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="integer",
     *                        example=1
     *                     ),
     *                     @OA\Property(
     *                         property="resultado",
     *                         type="string",
     *                         example="Normal"
     *                     ),
     *                     @OA\Property(
     *                         property="estado_registro",
     *                         type="string",
     *                         example="A"
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="size",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="ERROR")
     *         )
     *     )
     * )
     */
    public function getTf()
    {
        try{
            $datos = TestFatiga::where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
}
