<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
use App\Models\Distritos;

class UbicacionController extends Controller
{
    /**
     * Muestra todos los registros de departamento
     * @OA\Get (
     *     path="/api/ubicacion",
     *     summary="Muestra todas los departamentos con sus respectivas provincias y cada provincia con sus respectivos distritos",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Ubicación"},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array",property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                      @OA\Property(type="array",property="provincias",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                              @OA\Property(property="departamento_id", type="number", example=1),
     *                              @OA\Property(type="array",property="distritos",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="id", type="number", example=1),
     *                                      @OA\Property(property="distrito", type="string", example="ASUNCION"),
     *                                      @OA\Property(property="provincia_id", type="number", example=1),
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(property="size", type="number", example=1),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos"),
     *          )
     *      )
     * )
     */
    public function get(){
        $departamento=Departamento::with(['provincias.distritos'])->get();
        return response()->json(["data"=>$departamento,"size"=>count($departamento)]);
    }

    /**
     * Obtener departamento.
     * @OA\Get(
     *   path="/api/departamento",
     *   summary="Obtener departementos",
     *   security={{ "bearerAuth": {} }},
     *   tags={"Ubicación"},
     *    @OA\response(
     *       response=200,
     *       description="success",
     *       @OA\JsonContent(
     *           @OA\Property(
     *               type="array",
     *               property="data",
     *               @OA\Items(
     *                  type="object",
     *                   @OA\Property(
     *                      property="id",
     *                      type="number",
     *                      example="1"
     *                   ),
     *                   @OA\Property(
     *                       property="departamento",
     *                       type="string",
     *                       example="AMAZONAS"
     *                   ),
     *               )
     *           ),
     *           @OA\Property(
     *              type="count",
     *              property="size",
     *              example="1"
     *           ),
     *       )
     *    ),
     *    @OA\Response(
     *        response=400,
     *        description="invalid",
     *        @OA\JsonContent(
     *           @OA\Property(property="resp", type="string", example="Error al obtener departamento"),
     *        )
     *    )
     * )
     */
    public function departamentos(){
        $departamentos = Departamento::all();
        return response()->json([ "data" => $departamentos, "size" =>count($departamentos)]);
    }

    /**
     * Obtener provincia.
     * @OA\Get(
     *   path="/api/provincia/{departamentoId}",
     *   summary="Obtener provincia mediante el ID de departamento",
     *   security={{ "bearerAuth": {} }},
     *   tags={"Ubicación"},
     *   @OA\Parameter(
     *        description="ID del departamento",
     *        @OA\Schema(type="number"),
     *        name="departamentoId",
     *        in="path",
     *        required=true,
     *        example=1
     *    ),
     *    @OA\response(
     *       response=200,
     *       description="success",
     *       @OA\JsonContent(
     *           @OA\Property(
     *               type="array",
     *               property="data",
     *               @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="number",
     *                        example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="provincia",
     *                         type="string",
     *                         example="CHACHAPOYAS"
     *                     ),
     *                     @OA\Property(
     *                         property="departemento_id",
     *                         type="foreignId",
     *                         example="1"
     *                     ),
     *                 )
     *             ),
     *             @OA\Property(
     *               type="count",
     *               property="size",
     *               example="1"
     *             )
     *       )
     *    ),
     *    @OA\Response(
     *        response=400,
     *        description="invalid",
     *        @OA\JsonContent(
     *           @OA\Property(property="resp", type="string", example="Error al obtener las provincias"),
     *        )
     *    )
     * )
     */
    public function provincias($departamentoId){
        $provincias = Provincia::where('departamento_id',$departamentoId)->get();
        return response()->json([ "data" => $provincias, "size" =>count($provincias)]);
    }

    /**
     * Obtener distrito.
     * @OA\Get(
     *   path="/api/distrito/{provinciaId}",
     *   summary="Obtener distrito mediante el ID de provincia",
     *   security={{ "bearerAuth": {} }},
     *   tags={"Ubicación"},
     *   @OA\Parameter(
     *        description="ID de la provincia",
     *        @OA\Schema(type="number"),
     *        name="provinciaId",
     *        in="path",
     *        required=true,
     *        example=1
     *    ),
     *    @OA\response(
     *       response=200,
     *       description="success",
     *       @OA\JsonContent(
     *           @OA\Property(
     *               type="array",
     *               property="data",
     *               @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                        property="id",
     *                        type="number",
     *                        example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="distrito",
     *                         type="string",
     *                         example="CHACHAPOYAS"
     *                     ),
     *                     @OA\Property(
     *                         property="provincia_id",
     *                         type="foreignId",
     *                         example="1"
     *                     ),
     *                 )
     *             ),
     *             @OA\Property(
     *               type="count",
     *               property="size",
     *               example="1"
     *             )
     *       )
     *    ),
     *    @OA\Response(
     *        response=400,
     *        description="invalid",
     *        @OA\JsonContent(
     *           @OA\Property(property="resp", type="string", example="Error al obtener los distritos"),
     *        )
     *    )
     * )
     */
    public function distritos($provinciaId){
        $distritos = Distritos::where('provincia_id',$provinciaId)->get();
        return response()->json([ "data" => $distritos, "size" =>count($distritos)]);
    }
}
