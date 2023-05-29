<?php

namespace App\Http\Controllers\Bregma;

use App\Models\BregmaArea;
use App\Http\Controllers\Controller;
use App\Models\BregmaLocal;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BregmaAreaController extends Controller
{

    /**
     * Crea un Bregma Area
     * @OA\POST (
     *     path="/api/bregma/area/create",
     *     summary="Crea un Area de Bregma con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Area"},
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Id de bregma local",
     *          @OA\Schema(type="string"),name="bregma_local_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Parent_id",
     *          @OA\Schema(type="string"),name="parent_id",in="query",required= false
     *      ),
     *      @OA\Response(response=199,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Area creado"),
     *          )
     *      ),
     *      @OA\Response(response=403,description="invalid",
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
            BregmaArea::create([
                "nombre" => $request->nombre,
                "bregma_id" => $bregma->user_rol[0]->rol->bregma_id,
                "bregma_local_id" => $request->bregma_local_id,
                "parent_id" => $request->parent_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Area de bregma creado"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error " . $e]);
        }
    }

    /**
     * Actualiza un Area Bregma
     * @OA\PUT (
     *     path="/api/bregma/area/update/{id}",
     *     summary="Actualiza un area de Bregma con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Area"},
     *      @OA\Parameter(description="Id",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"),name="nombre",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Id de bregma local",
     *          @OA\Schema(type="string"),name="bregma_local_id",in="query",required= false
     *      ),
     *      @OA\Parameter(description="Parent_id",
     *          @OA\Schema(type="string"),name="parent_id",in="query",required= false
     *      ),
     *      @OA\Response(response=201,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Area actualizada"),
     *          )
     *      ),
     *      @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $Idarea)
    {
        DB::beginTransaction();
        try {
            $bregma = BregmaArea::find($Idarea);
            if ($bregma) {
                $bregma->fill(array(
                    "nombre" => $request->nombre,
                    "bregma_local_id" => $request->bregma_local_id,
                    "parent_id" => $request->parent_id
                ));
                $bregma->save();
                DB::commit();
                return response()->json(["resp" => "Area actualizada"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Elimina un Area de Bregma
     * @OA\DELETE (
     *     path="/api/bregma/area/delete/{id}",
     *     summary="Elimina un area de Bregma con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Area"},
     *      @OA\Parameter(description="Id",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=202,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Area eliminada"),
     *          )
     *      ),
     *      @OA\Response(response=402,description="invalid",
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
            $bregma = BregmaArea::find($Id);
            if ($bregma) {
                $bregma->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Area eliminada"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }



    /**
     * Mostrar las Area de Bregma
     * @OA\GET (
     *     path="/api/bregma/area/show",
     *     summary="Muestra las areas de Bregma con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Area"},
     *      @OA\Response(response=203,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="cocina"),
     *              @OA\Property(property="bregma_local_id", type="number", example=0),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="parent_id", type="number", example=null),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(property="depth", type="number", example=0),
     *              @OA\Property(property="path", type="string", example="1"),
     *              @OA\Property(property="slug", type="string", example="gastronomia"),
     *              @OA\Property(type="array",property="children",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="cocina"),
     *                      @OA\Property(property="bregma_local_id", type="number", example=0),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="parent_id", type="number", example=null),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(property="depth", type="number", example=0),
     *                      @OA\Property(property="path", type="string", example="1"),
     *                      @OA\Property(property="slug", type="string", example="gastronomia"),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function show()
    {
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma = BregmaArea::/*with('bregma.tipo_documento')
                ->*/where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)
                ->where('estado_registro', 'A')
                ->tree()
                ->get();
            $tree = $bregma->toTree();
            return response()->json(["data" => $tree, "size" => count($tree)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error" . $e]);
        }
    }

    /**
     * Mostrar las Área de que pertenecen a un local en específico
     * @OA\GET (
     *     path="/api/bregma/local/{idLocal}/areas/get",
     *     summary="Muestra las áreas de un local especificado, con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Area"},
     *      @OA\Parameter(description="Id del local a consultar",
     *          @OA\Schema(type="number"),name="idLocal",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Ventas"),
     *                      @OA\Property(property="bregma_local_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="parent_id", type="number", example=null),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  ),
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Ventas"),
     *                      @OA\Property(property="bregma_local_id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="parent_id", type="number", example=null),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al llamar Áreas del Local Bgrema), intente otra vez!"),
     *          )
     *      ),
     *      @OA\Response(response=404, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No se encontró el local (Bregma), o no existe."),
     *          )
     *      ),
     * )
     */
    public function get($idLocal)
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $local = BregmaLocal::find($idLocal);
            //return response()->json([$local]);
            if(!$local){
                return response()->json(["resp" => "No se encontró el local (Bregma), o no existe."], 404);
            }

            $bregma = BregmaArea::where('bregma_id', $user->user_rol[0]->rol->bregma_id)
                ->where('bregma_local_id', $local->id)
                ->where('estado_registro', 'A')
                ->get();

            return response()->json(["data" => $bregma, "size" => count($bregma)], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Áreas del Local (Bregma), intente otra vez!" . $e], 400);
        }
    }
}
