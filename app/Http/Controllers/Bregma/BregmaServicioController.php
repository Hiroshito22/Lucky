<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\AreaMedica;
use App\Models\Bregma;
use App\Models\BregmaPaquete;
use App\Models\BregmaServicio;
use App\Models\Capacitacion;
use App\Models\Examen;
use App\Models\Laboratorio;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BregmaServicioController extends Controller
{
    /**
     * Crear un Servicio de Bregma
     * @OA\Post(
     *     path = "/api/bregma/servicio/create",
     *     summary = "Create Bregma Servicio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Servicio"},
     *      @OA\Parameter(description="nombre del servicio",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="Servicio 1"),
     *      @OA\Parameter(description="una pequeña descripción",
     *          @OA\Schema(type="string"), name="descripcion", in="query", required=false, example=""),
     *      @OA\Parameter(description="Id del padre",
     *          @OA\Schema(type="number"), name="parent_id", in="query", required=false, example=""),
     *      @OA\Parameter(description="Carga un icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="descripcion", type="string"),
     *                      @OA\Property(property="parent_id", type="number"),
     *                      @OA\Property(property="icono", type="file"),
     *                  ),
     *                  example={
     *                      "nombre": "Servicio 1",
     *                      "descripcion": "",
     *                      "parent_id": "",
     *                      "icono": "",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Bregma Servicio creado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El Super Padre no se encontro"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear Bregma Servicio, intente otra vez!"),
     *          )
     *      ),
     * )
     */
    /*public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();

            $superPadre = BregmaServicio::where('id', $request->parent_id)->first();

            if ($request->parent_id == null) {
                BregmaServicio::create([
                    "servicio_id" => $request->servicio_id,
                    "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                    "nombre" => $request->nombre,
                    "icono" => $request->icono,
                    "parent_id" => null,
                ]);
                DB::commit();
                return response()->json(["resp" => "Bregma Servicio creado correctamente"], 200);
            } else {
                if (!$superPadre) {
                    return response()->json(["resp" => "El Super Padre no se encontro"], 401);
                }
                BregmaServicio::create([
                    "servicio_id" => $request->servicio_id,
                    "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                    "nombre" => $request->nombre,
                    "icono" => $request->icono,
                    "parent_id" => $request->parent_id,
                ]);
                DB::commit();
                return response()->json(["resp" => "Bregma Servicio creado correctamente"]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear Bregma Servicio, intente otra vez!" . $e], 400);
        }
    }*/
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $superPadre = BregmaServicio::where('id', $request->parent_id)->first();

            if ($request->parent_id == null | $request->parent_id == 0) {
                $servicio = BregmaServicio::create([
                    //"servicio_id" => $request->servicio_id,
                    "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                    "icono" => $request->icono,
                    "nombre" => $request->nombre,
                    "descripcion" => $request->descripcion,
                    "parent_id" => null,
                ]);

            } else {
                if (!$superPadre) {
                    return response()->json(["resp" => "El Super Padre no se encontro"], 401);
                }
                $servicio = BregmaServicio::create([
                    //"servicio_id" => $request->servicio_id,
                    "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                    "icono" => $request->icono,
                    "nombre" => $request->nombre,
                    "descripcion" => $request->descripcion,
                    "parent_id" => $request->parent_id,
                ]);
                /*$superPadre->update([
                    'servicio_id' => null,
                ]);*/
            }
            if ($request->hasFile('icono')) {
                $path = $request->icono->storeAs('public/servicio/icono', $servicio->id . '.' . $request->icono->extension());
                $image = $servicio->id . '.' . $request->icono->extension();
                $servicio->icono = $image;
                $servicio->save();
            }

            DB::commit();
            return response()->json(["resp" => "Bregma Servicio creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear Bregma Servicio, intente otra vez!" . $e], 400);
        }
    }

    /**
     * Actualizar el Servicio Bregma teniendo como parametro el id de bregma servicio
     * @OA\Post(
     *     path = "/api/bregma/servicio/update/{idBServicio}",
     *     summary = "Actualizar BregmaServicio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Servicio"},
     *      @OA\Parameter(description="id del servicio a actualizar",
     *          @OA\Schema(type="number"), name="idBServicio", in="path", required=true, example=1),
     *      @OA\Parameter(description="nuevo nombre de servicio",
     *          @OA\Schema(type="string"), name="nombre", in="query", required=false, example="examen Psicológico"),
     *      @OA\Parameter(description="una pequeña descripción",
     *          @OA\Schema(type="string"), name="descripcion", in="query", required=false, example=""),
     *      @OA\Parameter(description="Carga un icono",
     *          @OA\Schema(type="file"), name="icono", in="query", required=false, example=""
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="descripcion", type="string"),
     *                      @OA\Property(property="parent_id", type="number"),
     *                      @OA\Property(property="icono", type="file"),
     *                  ),
     *                  example={
     *                      "nombre": "Servicio 1",
     *                      "descripcion": "",
     *                      "parent_id": "",
     *                      "icono": "",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Bregma Servicio actualizado correctamente"),
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El id del Bregma Servicio no se encontro"),
     *          )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar Bregma Servicio, intente otra vez!"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $idBservicio)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $superPadre = BregmaServicio::where('estado_registro', 'A')->find($idBservicio);
            if (!$superPadre) {
                return response()->json(["resp" => "El id del Bregma Servicio no se encontro"], 400);
            }
            $superPadre->fill([
                //"servicio_id" => $request->servicio_id,
                "bregma_id" => $datos->user_rol[0]->rol->bregma_id,
                "icono" => $request->icono,
                "nombre" => $request->nombre,
                "descripcion" => $request->descripcion,
            ])->save();

            if ($request->hasFile('icono')) {
                Storage::delete('servicio/icono/' . $superPadre->getRawOriginal('icono'));
                $image = $superPadre->id . now()->format('Ymd_hms') . '.' . $request->icono->extension();
                $request->file('icono')->storeAs('servicio/icono/', $image);
                $superPadre->icono = $image;
                $superPadre->save();
            }

            DB::commit();
            return response()->json(["resp" => "Bregma Servicio actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al actualizar Bregma Servicio, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Eliminar el Servicio Bregma teniendo como parametro el id de bregma servicio
     * @OA\Delete (
     *     path="/api/bregma/servicio/delete/{idBServicio}",
     *     summary="Inhabilita el registro Bregma Servicio teniendo como parametro el id de BregmaServicio",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Bregma - Servicio"},
     *      @OA\Parameter(description="ID del registro de Bregma Servicio que se desea eliminar",
     *          @OA\Schema(type="number"), name="idBServicio", in="path", required= true, example=2
     *      ),
     *      @OA\Response( response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Bregma Servicio inabititado correctamente"),
     *          )
     *      ),
     *      @OA\Response( response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="El id del Bregma Servicio no se encontro"),
     *          ),
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al eliminar Bregma Servicio, intente otra vez!"),
     *          )
     *      ),
     * )
     */
    public function delete($idBservicio)
    {
        DB::beginTransaction();
        try {
            //$usuario = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $superPadre = BregmaServicio::where('estado_registro', 'A')->find($idBservicio);
            if (!$superPadre) {
                return response()->json(["resp" => "El id del Bregma Servicio no se encontro"], 400);
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
            return response()->json(["resp" => "Bregma Servicio inabititado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al eliminar Bregma Servicio, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Mostrar todos los datos de Bregma Servicio
     * @OA\Get (
     *     path="/api/bregma/servicio/get",
     *     summary="Muestra datos de Bregma-Servicio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Servicio"},
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Nuevo Servicio"),
     *                      @OA\Property(property="icono", type="file", example=""),
     *                      @OA\Property(property="descripcion", type="string", example="Servicio General"),
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
     *                              @OA\Property(property="descripcion", type="string", example="Servicio General"),
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
     *                                      @OA\Property(property="descripcion", type="string", example="Servicio General"),
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
     *             @OA\Property(property="resp", type="string", example="Bregma Servicio no se encontro o no existe"),
     *         )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Bregma Servicio, intente otra vez!"),
     *         ),
     *      )
     * )
    */
    public function get()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma = $usuario->user_rol[0]->rol->bregma_id;
            $servicios = BregmaServicio::where('estado_registro', 'A')->where('bregma_id', $bregma)->tree()->get();

            if (!$servicios) {
                return response()->json(['resp' => 'Bregma Servicio no se encontro o no existe'], 400);
            }
            $tree = $servicios->toTree();

            $tree->map(function ($node) {
                $node->incremental_id = substr($node->path, -1);
                if ($node->children) {
                    $node->children = $node->children->map(function ($child) {
                        $child->incremental_id = substr($child->path, -1);
                        if ($child->children) {
                            $stack = [$child->children];
                            while ($stack) {
                                $children = array_shift($stack);
                                foreach ($children as $grandchild) {
                                    $grandchild->incremental_id = substr($grandchild->path, -1);
                                    if ($grandchild->children) {
                                        array_push($stack, $grandchild->children);
                                    }
                                }
                            }
                        }
                        return $child;
                    });
                }
                return $node;
            });

            return response()->json(["data" => $tree, "size" => count($tree)]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Bregma Servicio, intente otra vez!" . $e], 500);
        }
    }

    public function getAll()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma = $usuario->user_rol[0]->rol->bregma_id;
            $servicios = BregmaServicio::with('bregma_paquete.area_medica', 'bregma_paquete.capacitacion', 'bregma_paquete.examen', 'bregma_paquete.laboratorio')
                ->where('estado_registro', 'A')->where('bregma_id', $bregma)->get();
            //return response()->json($servicios);

            if (!$servicios) {
                return response()->json(['resp' => 'Bregma Servicio no se encontro o no existe'], 400);
            }


            return response()->json(["data" => $servicios, "size" => count($servicios)]);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Bregma Servicio, intente otra vez!" . $e], 500);
        }
    }

}
