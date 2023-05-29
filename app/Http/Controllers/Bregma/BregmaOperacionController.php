<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\AreaMedica;
use App\Models\BregmaOperacion;
use App\Models\Capacitacion;
use App\Models\Examen;
use App\Models\Laboratorio;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BregmaOperacionController extends Controller
{
    /**
     * Crear BregmaOperacio
     * @OA\Post(
     *     path = "/api/bregma/operacion/create",
     *     summary = "Create BregmaOperación",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Operación"},
     *      @OA\Parameter(description="nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="Operación 1"),
     *      @OA\Parameter(description="icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""),
     *      @OA\Parameter(description="parent_id",
     *          @OA\Schema(type="number"), name="parent_id", in="query", required=false, example=""),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="icono", type="file"),
     *                      @OA\Property(property="parent_id", type="number"),
     *                  ),
     *                  example={
     *                      "nombre": "Operación 1",
     *                      "icono": "",
     *                      "parent_id": "",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Bregma Operación creado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El Super Padre no se encontro"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear Bregma Operación, intente otra vez!"),
     *          )
     *      ),
     * )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            $superPadre = BregmaOperacion::where('id', $request->parent_id)->first();

            if ($request->parent_id == null) {
                BregmaOperacion::create([
                    "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                    "nombre" => $request->nombre,
                    "icono" => $request->icono,
                    "parent_id" => null,
                ]);
                DB::commit();
                return response()->json(["resp" => "Bregma Operación creado correctamente"], 200);
            } else {
                if (!$superPadre) {
                    return response()->json(["resp" => "El Super Padre no se encontró"], 401);
                }
                BregmaOperacion::create([
                    "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                    "nombre" => $request->nombre,
                    "icono" => $request->icono,
                    "parent_id" => $request->parent_id,
                ]);
                DB::commit();
                return response()->json(["resp" => "Bregma Operación creado correctamente"]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear Bregma Operación, intente otra vez!" . $e], 400);
        }
    }

    /**
     * Actualizar BregmaOperacion
     * @OA\Put(
     *     path = "/api/bregma/operacion/update/{idBoperacion}",
     *     summary = "Actualizar BregmaOperacion",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Operación"},
     *      @OA\Parameter(description="id",
     *          @OA\Schema(type="number"), name="idBoperacion", in="path", required=true, example=1),
     *      @OA\Parameter(description="nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="Operación actualizado"),
     *      @OA\Parameter(description="icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="icono", type="file"),
     *                  ),
     *                  example={
     *                      "nombre": "examen Psicológico",
     *                      "icono": "",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Bregma Operación actualizado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El id del Bregma Operación no se encontro"),
     *          )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar Bregma Operación, intente otra vez!"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $idBoperacion)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            $superPadre = BregmaOperacion::where('estado_registro', 'A')->find($idBoperacion);
            if (!$superPadre) {
                return response()->json(["resp" => "El id del Bregma Operació no se encontro"], 400);
            }

            $superPadre->fill([
                "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                "nombre" => $request->nombre,
                "icono" => $request->icono,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Bregma Operación actualizado correctamente"], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al actualizar Bregma Operación, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Eliminar Bregma Operación
     * @OA\Delete (
     *     path="/api/bregma/operacion/delete/{idBoperacion}",
     *     summary="Inhabilita el registro Bregma Operación teniendo como parametro el id de BregmaOperacion",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Bregma - Operación"},
     *      @OA\Parameter(
     *          description="Numero de ID del registro de Bregma Operación que se desea eliminar",
     *          @OA\Schema(type="number"),
     *          name="idBoperacion",
     *          in="path",
     *          required= true,
     *          example=2
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Bregma Operación inabititado correctamente"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El id del Bregma Operación no se encontro"),
     *          ),
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al eliminar Bregma Operación, intente otra vez!"),
     *          )
     *      ),
     * )
     */
    public function delete($idBoperacion)
    {
        DB::beginTransaction();
        try {
            $superPadre = BregmaOperacion::where('estado_registro', 'A')->find($idBoperacion);
            if (!$superPadre) {
                return response()->json(["resp" => "El id del Bregma Operación no se encontro"], 400);
            }
            $superPadre->fill([
                "parent_id" => null,
                "estado_registro" => "I",
            ])->save();

            while ($superPadre->children->count() > 0) {
                foreach ($superPadre->children as $superHijo) {
                    $superPadre = $superHijo;
                    $superHijo->fill([
                        "parent_id" => null,
                        "estado_registro" => "I",
                    ])->save();
                }
            }
            DB::commit();
            return response()->json(["resp" => "Bregma Operación inabititado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al eliminar Bregma Operación, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Mostrar Datos de Bregma Operación
     * @OA\Get (
     *     path="/api/bregma/operacion/show",
     *     summary="Muestra datos de Bregma-Operación",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Operación"},
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Nuevo Servicio"),
     *                      @OA\Property(property="icono", type="file", example=""),
     *                      @OA\Property(property="parent_id", type="number", example=""),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                      @OA\Property(property="depth", type="number", example=0),
     *                      @OA\Property(property="path", type="string", example="1"),
     *                      @OA\Property(property="slug", type="string", example="Nuevo Servicio"),
     *
     *                      @OA\Property(type="array", property="children",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="bregma_id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="Nuevo Servicio"),
     *                              @OA\Property(property="icono", type="file", example=""),
     *                              @OA\Property(property="parent_id", type="number", example=""),
     *                              @OA\Property(property="estado_registro", type="char", example="A"),
     *                              @OA\Property(property="depth", type="number", example=0),
     *                              @OA\Property(property="path", type="string", example="1"),
     *                              @OA\Property(property="slug", type="string", example="Nuevo Servicio"),
     *
     *                              @OA\Property(type="array", property="children",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="id", type="number", example=1),
     *                                      @OA\Property(property="bregma_id", type="number", example=1),
     *                                      @OA\Property(property="nombre", type="string", example="Nuevo Servicio"),
     *                                      @OA\Property(property="icono", type="file", example=""),
     *                                      @OA\Property(property="parent_id", type="number", example=""),
     *                                      @OA\Property(property="estado_registro", type="char", example="A"),
     *                                      @OA\Property(property="depth", type="number", example=0),
     *                                      @OA\Property(property="path", type="string", example="1"),
     *                                      @OA\Property(property="slug", type="string", example="Nuevo Servicio"),
     *                                  )
     *                              ),
     *                          )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(type="count", property="size", example="1")
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Bregma Operación no se encontro o no existe"),
     *         )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Bregma Operación, intente otra vez!"),
     *         ),
     *      )
     * )
     */
    public function show()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma = $usuario->user_rol[0]->rol->bregma_id;
            $supePadre = BregmaOperacion::where('estado_registro', 'A')->where('bregma_id',$bregma)->tree()->get();

            if (!$supePadre) {
                return response()->json(['resp' => 'Bregma Operación no se encontro o no existe'], 400);
            }

            $tree = $supePadre->toTree();
            return response()->json(["data" => $tree, "size" => count($tree)]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Bregma Operación, intente otra vez!" . $e], 500);
        }
    }

}
