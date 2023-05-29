<?php

namespace App\Http\Controllers;

use App\Models\EntidadBancaria;
use App\Models\EntidadPago;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntidadBancariaController extends Controller
{
    /**
     * Get
     * @OA\Get (
     *     path="/api/EntidadBancaria/get",
     *     tags={"Entidad Bancaria"},
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
     *                        property="nombre",
     *                        type="string",
     *                        example="nombreExample"
     *                     ),
     *                     @OA\Property(
     *                        property="logo",
     *                        type="string",
     *                        example="logoExample"
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

    public function get(){
        try {
            $entidad_bancaria = EntidadBancaria::where('estado_registro','A')->get();
            return response()->json(["data"=>$entidad_bancaria,"size"=>count($entidad_bancaria)]);

        } catch (Exception $e) {
            return response()->json(["No se encuentran Registros" => $e],500);
        }
    }
    /**
     * Crea una entidad bancaria
     * @OA\POST (
     *     path="/api/entidad_bancaria/create",
     *     summary="Crea los datos de la entidad con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad Bancaria"},
     *      @OA\Parameter(
     *          description="nombre",
     *          @OA\Schema(type="string"),
     *          name="nombre",
     *          in="query",
     *          required= false,
     *          example="bbca"
     *          ),
     *      @OA\Parameter(
     *          description="logo",
     *          @OA\Schema(type="char"),
     *          name="logo",
     *          in="query",
     *          required= false,
     *          example="bbvca"
     *          ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="bbvca"),
     *              @OA\Property(property="logo", type="char", example="bbvca"),
     *              @OA\Property(property="estado_registro", type="char", example="A"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error"),
     *          )
     *      ),
     * )
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $entidad = EntidadBancaria::create([
                "nombre" => $request->nombre,
                "logo" => $request->logo
            ]);
            DB::commit();
            return response()->json($entidad);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error"]);
        }
    }

        /**
     * Actualiza una entidad bancaria
     * @OA\PUT (
     *     path="/api/entidad_bancaria/update/{id}",
     *     summary="Actualiza los datos de la entidad con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad Bancaria"},
     *      @OA\Parameter(
     *          description="Id de la Entidad a actualizar",
     *          @OA\Schema(type="number"),
     *          name="Id",
     *          in="path",
     *          required= True,
     *          example=1
     *          ),
     *      @OA\Parameter(
     *          description="nombre",
     *          @OA\Schema(type="string"),
     *          name="nombre",
     *          in="query",
     *          required= false,
     *          example="bbca"
     *          ),
     *      @OA\Parameter(
     *          description="logo",
     *          @OA\Schema(type="char"),
     *          name="logo",
     *          in="query",
     *          required= false,
     *          example="bbvca"
     *          ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Entidad Actualizada"),     *
     *          )
     *      ),
     *      @OA\Response(
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
            EntidadBancaria::create([
                'nombre' => $request->nombre,
                'logo' => $request->logo
            ]);
            DB::commit();
            return response()->json(["resp" => "Entidad Bancaria creada correctamente"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Elimina una Entidad Bancaria
     * @OA\DELETE (
     *     path="/api/EntidadBancaria/delete/{id}",
     *     summary="Elimina una Entidad Bancaria seleccionado con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad Bancaria"},
     *      @OA\Parameter( description="Id de la Entidad Bancaria para eliminar",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Entidad Bancaria eliminada"),
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

            $entidad = EntidadBancaria::find($Id);
            //return response()->json($entidad);
            $objetos = EntidadPago::where("entidad_bancaria_id",$Id)->get();
            $contador = count($objetos);
            //return response()->json($pago);
            if (!$entidad) {
                return response()->json(["Resp" => "no existe la entidad"]);
            } else {
                while($contador>0){
                    $pago = EntidadPago::where("entidad_bancaria_id",$Id)->first();
                    $pago->fill([
                        "entidad_bancaria_id" => null,
                    ])->save();
                    $contador  -= 1;
                }
                $entidad ->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "entidad eliminada y actualizada"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

}
