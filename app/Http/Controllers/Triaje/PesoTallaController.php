<?php

namespace App\Http\Controllers\Triaje;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EvaluacionMedica;
Use App\Models\FichaOcupacional;
use App\Models\PesoTalla;
use Exception;
use Illuminate\Support\Facades\DB;

class PesoTallaController extends Controller
{
    /**
     * Get
     * @OA\Get (
     *     path="/api/triaje/pesotalla/get",
     *     tags={"Triaje - Peso Talla"},
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
     *                         property="triaje_id",
     *                         type="foreignId",
     *                         example=null
     *                     ),
     *                     @OA\Property(
     *                         property="peso",
     *                         type="double",
     *                         example=2.5
     *                     ),
     *                     @OA\Property(
     *                         property="talla",
     *                         type="double",
     *                         example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="cintura",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="cadera",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="max_inspiracion",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="expiracion_forzada",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="observaciones",
     *                        type="string",
     *                        example="example observaciones"
     *                     ),
     *                     @OA\Property(
     *                        property="estado_registro",
     *                        type="char",
     *                        example="A"
     *                     )
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
            $datos = PesoTalla::where('estado_registro', 'A')->get();
            return response()->json(["data" => $datos, "size" => count($datos)]);
        }catch(Exception $e){
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * Create
     * @OA\Post (
     *     path="/api/triaje/pesotalla/create",
     *     tags={"Triaje - Peso Talla"},
     *     @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Triaje'",
     *          @OA\Schema(type="integer"),
     *          name="triaje_id",
     *          in="query",
     *          required= true,
     *          example=null
     *      ),
     *      @OA\Parameter(
     *          description="El peso del Paciente",
     *          @OA\Schema(type="double"),
     *          name="peso",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="La talla del Paciente",
     *          @OA\Schema(type="double"),
     *          name="talla",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="La medida de la cintura del Paciente",
     *          @OA\Schema(type="double"),
     *          name="cintura",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="La medida de la cadera del Paciente",
     *          @OA\Schema(type="double"),
     *          name="cadera",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="Presiones respiratorias del Paciente",
     *          @OA\Schema(type="double"),
     *          name="max_inspiracion",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="Presiones respiratorias del Paciente",
     *          @OA\Schema(type="double"),
     *          name="expiracion_forzada",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="Las observaciones y/o comentarios acerca del Paciente",
     *          @OA\Schema(type="string"),
     *          name="observaciones",
     *          in="query",
     *          required= false,
     *          example="example observaciones"
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                         property="triaje_id",
     *                         type="foreignId",
     *                         example=null
     *                     ),
     *                     @OA\Property(
     *                         property="peso",
     *                         type="double",
     *                         example=2.5
     *                     ),
     *                     @OA\Property(
     *                         property="talla",
     *                         type="double",
     *                         example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="cintura",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="cadera",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="max_inspiracion",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="expiracion_forzada",
     *                        type="double",
     *                        example=2.5
     *                     ),
     *                     @OA\Property(
     *                        property="observaciones",
     *                        type="string",
     *                        example="example observaciones"
     *                     ),

     *                     @OA\Property(
     *                        property="estado_registro",
     *                        type="char",
     *                        example="A"
     *                     )
     *                 ),
     *                 example={
     *                     "triaje_id": null,
     *                     "peso":2.5,
     *                     "talla":2.5,
     *                     "cintura":2.5,
     *                     "cadera":2.5,
     *                     "max_inspiracion":2.5,
     *                     "expiracion_forzada":2.5,
     *                     "observaciones":"example observaciones",
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
            // $search1 = FichaOcupacional::find($request['ficha_ocupacional_id']);
            // if ($request['ficha_ocupacional_id'] == 0) {
            //     $request['ficha_ocupacional_id'] = null;
            // }elseif($request['ficha_ocupacional_id'] == 0){
            //     $request['ficha_ocupacional_id'] = null;
            // }
            // elseif($search1 === null) {
            //     return response()->json(["Error: El ID ingresado de 'Ficha Ocupacional' no existe..."]);
            // }
            // if (!is_double($request['peso']) && !is_int($request['peso'])) {
            //     return response()->json(['error' => 'El campo debe ser un número decimal o entero.'],400);
            // }elseif (!is_double($request['talla']) && !is_int($request['talla'])) {
            //     return response()->json(['error' => 'El campo debe ser un número decimal o entero.'],400);
            // }
            // if('ficha_ocupacional_id' == 0){
            //     // $request->replace(['servicio_clinica_id' => null]);
            //     $request->merge(['ficha_ocupacional_id' => null]);
            //     $request->request->set('ficha_ocupacional_id', null);
            // }
            PesoTalla::create([
                'triaje_id' => $request->triaje_id,
                'peso' => $request->peso,
                'talla' => $request->talla,
                'cintura' => $request->cintura,
                'cadera' => $request->cadera,
                'max_inspiracion' => $request->max_inspiracion,
                'expiracion_forzada' => $request->expiracion_forzada,
                'observaciones' => $request->observaciones,
            ]);
            DB::commit();
            return response()->json(["resp" => "Dato creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * Update
     * @OA\Put (
     *     path="/api/triaje/pesotalla/update/{id}",
     *     tags={"Triaje - Peso Talla"},
     *          *     @OA\Parameter(
     *          description="La ID (Llave Primaria) de la tabla 'Triaje'",
     *          @OA\Schema(type="integer"),
     *          name="triaje_id",
     *          in="query",
     *          required= true,
     *          example=null
     *      ),
     *      @OA\Parameter(
     *          description="El peso del Paciente",
     *          @OA\Schema(type="double"),
     *          name="peso",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="La talla del Paciente",
     *          @OA\Schema(type="double"),
     *          name="talla",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="La medida de la cintura del Paciente",
     *          @OA\Schema(type="double"),
     *          name="cintura",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="La medida de la cadera del Paciente",
     *          @OA\Schema(type="double"),
     *          name="cadera",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="Presiones respiratorias del Paciente",
     *          @OA\Schema(type="double"),
     *          name="max_inspiracion",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="Presiones respiratorias del Paciente",
     *          @OA\Schema(type="double"),
     *          name="expiracion_forzada",
     *          in="query",
     *          required= false,
     *          example=2.5
     *      ),
     *      @OA\Parameter(
     *          description="Las observaciones y/o comentarios acerca del Paciente",
     *          @OA\Schema(type="string"),
     *          name="observaciones",
     *          in="query",
     *          required= false,
     *          example="example observaciones"
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="ficha_ocupacional_id",
     *                          type="foreignId"
     *                      ),
     *                      @OA\Property(
     *                          property="anamnesis",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="talla",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="peso",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="imc",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="diagnostico_nutricional",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="cintura",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="cadera",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="cintura_cadera",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="observaciones",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="max_inspiracion",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="expiracion_forzada",
     *                          type="double"
     *                      ),
     *                      @OA\Property(
     *                          property="perimetro_cuello",
     *                          type="double"
     *                      )
     *                 ),
     *                 example={
     *                     "ficha_ocupacional_id":null,
     *                     "anamnesis":"example anamnesis",
     *                     "talla":2.5,
     *                     "peso":2.5,
     *                     "imc":null,
     *                     "diagnostico_nutricional":"example diagnostico_nutricional",
     *                     "cintura":2.5,
     *                     "cadera":2.5,
     *                     "cintura_cadera":null,
     *                     "observaciones":"example observaciones",
     *                     "max_inspiracion":2.5,
     *                     "expiracion_forzada":2.5,
     *                     "perimetro_cuello":2.5
     *                }
     *             )
     *         )
     *      ),
     *         @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Registro actualizado correctamente")
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
            // $search1 = FichaOcupacional::find($request['ficha_ocupacional_id']);
            // if ($request['ficha_ocupacional_id'] == 0) {
            //     $request['ficha_ocupacional_id'] = null;
            // }elseif($request['ficha_ocupacional_id'] == 0){
            //     $request['ficha_ocupacional_id'] = null;
            // }
            // elseif($search1 === null) {
            //     return response()->json(["Error: El ID ingresado de 'Ficha Ocupacional' no existe..."]);
            // }
            // if (!is_double($request['peso']) && !is_int($request['peso'])) {
            //     return response()->json(['error' => 'El campo debe ser un número decimal o entero.'],400);
            // }elseif (!is_double($request['talla']) && !is_int($request['talla'])) {
            //     return response()->json(['error' => 'El campo debe ser un número decimal o entero.'],400);
            // }
            $datos = PesoTalla::where('estado_registro', 'A')->find($id);
            // $prom_imc = EvaluacionMedica::where('imc','double')->find($id);
            // if(!$prom_imc){
            //     return response()->json(['resp'=>"Usted no puede cambiar este dato"]);
            // }
            $datos->fill([
                'triaje_id' => $request->triaje_id,
                'peso' => $request->peso,
                'talla' => $request->talla,
                'cintura' => $request->cintura,
                'cadera' => $request->cadera,
                'max_inspiracion' => $request->max_inspiracion,
                'expiracion_forzada' => $request->expiracion_forzada,
                'observaciones' => $request->observaciones,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Datos actualizado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * Delete
     * @OA\Delete (
     *     path="/api/triaje/pesotalla/delete/{id}",
     *     tags={"Triaje - Peso Talla"},
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
            $datos = PesoTalla::where('estado_registro', 'A')->find($id);
            if(!$datos){
                return response()->json(["resp"=>"Usuario ya Inactivado"]);
            }
            $datos->fill([
                'estado_registro' => 'I',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Dato inactivo correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
    /**
     * Reintegrar
     * @OA\Put (
     *     path="/api/triaje/pesotalla/reintegrar/{id}",
     *     tags={"PesoTallaList"},
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
            $datos = PesoTalla::where('estado_registro', 'I')->find($id);
            if(!$datos){
                return response()->json(["resp"=>"Registro ya ha sido Activado"]);
            }
            $datos->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Registro Activado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e]);
        }
    }
}
