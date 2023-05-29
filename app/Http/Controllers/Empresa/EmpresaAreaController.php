<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\EmpresaArea;
use App\Models\EmpresaLocal;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaAreaController extends Controller
{

    /**
     * Crea un Empresa Area
     * @OA\POST (
     *     path="/api/empresa/area/create",
     *     summary="Crea un Area de Empresa con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Area"},
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Numero de Trabajadores",
     *          @OA\Schema(type="string"), name="numero_trabajadores", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Local de Empresa",
     *          @OA\Schema(type="string"), name="empresa_local_id", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Parent_id",
     *          @OA\Schema(type="string"),name="parent_id",in="query",required= false
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="numero_trabajadores", type="string"),
     *                      @OA\Property(property="empresa_local_id", type="string"),
     *                      @OA\Property(property="parent_id", type="string"),
     *                 ),
     *                 example={
     *                     "nombre": "Bregma Area",
     *                     "numero_trabajadores": "12",
     *                     "empresa_local_id": "1",
     *                     "parent_id": "",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Area creado"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
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
            $empresa = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            EmpresaArea::create([
                "nombre" => $request->nombre,
                "numero_trabajadores" => $request->numero_trabajadores,
                "empresa_id" => $empresa->user_rol[0]->rol->empresa_id,
                "empresa_local_id" => $request->empresa_local_id,
                "parent_id" => $request->parent_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Area de Empresa creado"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error " . $e]);
        }
    }


    /**
     * Actualiza un Area Empresa
     * @OA\PUT (
     *     path="/api/empresa/area/update/{id}",
     *     summary="Actualiza un area de Empresa con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Area"},
     *      @OA\Parameter(description="Id",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"),name="nombre",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Numero de Trabajadores",
     *          @OA\Schema(type="string"), name="numero_trabajadores", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Local de Empresa",
     *          @OA\Schema(type="string"), name="empresa_local_id", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Parent_id",
     *          @OA\Schema(type="string"),name="parent_id",in="query",required= false
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="numero_trabajadores", type="string"),
     *                      @OA\Property(property="empresa_local_id", type="string"),
     *                      @OA\Property(property="parent_id", type="string"),
     *                 ),
     *                 example={
     *                     "nombre": "Bregma Area",
     *                     "numero_trabajadores": "12",
     *                     "empresa_local_id": "1",
     *                     "parent_id": "",
     *                }
     *             )
     *         )
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
            $empresa = EmpresaArea::find($Idarea);
            if ($empresa) {
                $empresa->fill(array(
                    "nombre" => $request->nombre,
                    "numero_trabajadores" => $request->numero_trabajadores,
                    "empresa_local_id" => $request->empresa_local_id,
                    "parent_id" => $request->parent_id
                ));
                $empresa->save();
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
     * Elimina un Area de Empresa
     * @OA\DELETE (
     *     path="/api/empresa/area/delete/{id}",
     *     summary="Elimina un area de Empresa con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Area"},
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
            $empresa = EmpresaArea::find($Id);
            if ($empresa) {
                $empresa->fill([
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
     * Mostrar las Area de Empresa
     * @OA\GET (
     *     path="/api/empresa/area/show",
     *     summary="Muestra las areas de Empresa con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Area"},
     *      @OA\Response(response=203,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="cocina"),
     *              @OA\Property(property="numero_trabajadores", type="string", example="cocina"),
     *              @OA\Property(property="empresa_local_id", type="number", example=0),
     *              @OA\Property(property="empresa_id", type="number", example=1),
     *              @OA\Property(property="parent_id", type="number", example=null),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(property="depth", type="number", example=0),
     *              @OA\Property(property="path", type="string", example="1"),
     *              @OA\Property(property="slug", type="string", example="gastronomia"),
     *
     *              @OA\Property(type="array",property="children",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="cocina"),
     *                      @OA\Property(property="numero_trabajadores", type="string", example="cocina"),
     *                      @OA\Property(property="empresa_local_id", type="number", example=0),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
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
     *          response=403,
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
            $userempresa = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $empresa = EmpresaArea::with('empresa.tipo_documento')
                ->where('empresa_id', $userempresa->user_rol[0]->rol->empresa_id)
                ->where('estado_registro', 'A')
                ->tree()
                ->get();
            $tree = $empresa->toTree();
            return response()->json(["data" => $tree, "size" => count($tree)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error" . $e]);
        }
    }

    /**
     * Mostrar las Area de Empresa que pertenecen a un local en específico
     * @OA\GET (
     *     path="/api/empresa/local/{idLocal}/areas/get",
     *     summary="Muestra las areas de la Empresa de un local especificado, con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Area"},
     *      @OA\Parameter(description="Id del local a consultar",
     *          @OA\Schema(type="number"),name="idLocal",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Ventas"),
     *                      @OA\Property(property="numero_trabajadores", type="string", example="10"),
     *                      @OA\Property(property="empresa_local_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
     *                      @OA\Property(property="parent_id", type="number", example=null),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  ),
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="Ventas"),
     *                      @OA\Property(property="numero_trabajadores", type="string", example="10"),
     *                      @OA\Property(property="empresa_local_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
     *                      @OA\Property(property="parent_id", type="number", example=null),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=400, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al llamar Áreas del Local, intente otra vez!"),
     *          )
     *      ),
     *      @OA\Response(response=404, description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No se encontró el local, o no existe."),
     *          )
     *      ),
     * )
     */
    public function get($idLocal)
    {
        try {
            $userempresa = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $local = EmpresaLocal::find($idLocal);
            if(!$local){
                return response()->json(["resp" => "No se encontró el local, o no existe."], 404);
            }

            $empresa = EmpresaArea::where('empresa_id', $userempresa->user_rol[0]->rol->empresa_id)
                ->where('empresa_local_id', $local->id)
                ->where('estado_registro', 'A')
                ->get();

            return response()->json(["data" => $empresa, "size" => count($empresa)], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar Áreas del Local, intente otra vez!" . $e], 400);
        }
    }

}
