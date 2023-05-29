<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\EmpresaLocal;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaLocalController extends Controller
{
    /**
     * Crea un local Empresa
     * @OA\POST (
     *     path="/api/empresa/local/create",
     *     summary="Crea un local de Bregma con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Local"},
     *      @OA\Parameter(description="nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Direccion del Local",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Latitud",
     *          @OA\Schema(type="string"),name="latitud",in="query",required= true
     *      ),
     *      @OA\Parameter(description="longitud",
     *          @OA\Schema(type="string"),name="longitud",in="query",required= true
     *      ),
     *      @OA\Parameter(description="departamento_id",
     *          @OA\Schema(type="number"),name="departamento_id",in="query",required= true
     *      ),
     *      @OA\Parameter(description="provincia_id",
     *          @OA\Schema(type="number"),name="provincia_id",in="query",required= true
     *      ),
     *      @OA\Parameter(description="distrito_id",
     *          @OA\Schema(type="number"),name="distrito_id",in="query",required= true
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="direccion", type="string"),
     *                      @OA\Property(property="latitud", type="string"),
     *                      @OA\Property(property="longitud", type="string"),
     *                      @OA\Property(property="departamento_id", type="number"),
     *                      @OA\Property(property="provincia_id", type="number"),
     *                      @OA\Property(property="distrito_id", type="number"),
     *
     *                 ),
     *                 example={
     *                     "nombre": "Local Nuevo",
     *                     "direccion": "av. los Girasoles",
     *                     "latitud": "",
     *                     "longitud": "",
     *                     "departamento_id": 1,
     *                     "provincia_id": 1,
     *                     "distrito_id": 1,
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(response=206,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Local creado"),
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
        DB::beginTransaction();
        try {
            $userempresa = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            EmpresaLocal::create([
                "nombre" => $request->nombre,
                "direccion" => $request->direccion,
                "latitud" => $request->latitud,
                "longitud" => $request->longitud,
                "empresa_id" => $userempresa->user_rol[0]->rol->empresa_id,
                "departamento_id" => $request->departamento_id,
                "provincia_id" => $request->provincia_id,
                "distrito_id" => $request->distrito_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Empresa Local creado"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Actualiza un Local Empresa
     * @OA\PUT (
     *     path="/api/empresa/local/update/{id}",
     *     summary="Actualiza un local con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Local"},
     *      @OA\Parameter(description="Id",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Parameter(description="nombre",
     *          @OA\Schema(type="string"),name="nombre",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Direccion del Local",
     *          @OA\Schema(type="string"),name="direccion",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Latitud",
     *          @OA\Schema(type="string"),name="latitud",in="query",required= true
     *      ),
     *      @OA\Parameter(description="longitud",
     *          @OA\Schema(type="string"),name="longitud",in="query",required= true
     *      ),
     *      @OA\Parameter(description="departamento_id",
     *          @OA\Schema(type="number"),name="departamento_id",in="query",required= true
     *      ),
     *      @OA\Parameter(description="provincia_id",
     *          @OA\Schema(type="number"),name="provincia_id",in="query",required= true
     *      ),
     *      @OA\Parameter(description="distrito_id",
     *          @OA\Schema(type="number"),name="distrito_id",in="query",required= true
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                      @OA\Property(property="nombre", type="string"),
     *                      @OA\Property(property="direccion", type="string"),
     *                      @OA\Property(property="latitud", type="string"),
     *                      @OA\Property(property="longitud", type="string"),
     *                      @OA\Property(property="departamento_id", type="number"),
     *                      @OA\Property(property="provincia_id", type="number"),
     *                      @OA\Property(property="distrito_id", type="number"),
     *
     *                 ),
     *                 example={
     *                     "nombre": "Local Nuevo",
     *                     "direccion": "av. los Girasoles",
     *                     "latitud": "",
     *                     "longitud": "",
     *                     "departamento_id": 1,
     *                     "provincia_id": 1,
     *                     "distrito_id": 1,
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Local actualizado"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $Idlocal)
    {
        DB::beginTransaction();
        try {
            $local = EmpresaLocal::find($Idlocal);
            if ($local) {
                $local->fill(array(
                    "nombre" => $request->nombre,
                    "direccion" => $request->direccion,
                    "latitud" => $request->latitud,
                    "longitud" => $request->longitud,
                    "departamento_id" => $request->departamento_id,
                    "provincia_id" => $request->provincia_id,
                    "distrito_id" => $request->distrito_id
                ));
                $local->save();
                DB::commit();
                return response()->json(["resp" => "Local actualizado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Elimina un Local
     * @OA\DELETE (
     *     path="/api/empresa/local/delete/{id}",
     *     summary="Elimina un local con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Local"},
     *      @OA\Parameter(description="Id",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Local eliminado"),
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
            $local = EmpresaLocal::find($Id);
            if ($local) {
                $local->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Local eliminado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Mostrar Locales
     * @OA\GET (
     *     path="/api/empresa/local/show",
     *     summary="Muestra los locales con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Empresa Local"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="Juan"),
     *              @OA\Property(property="direccion", type="string", example="AV. Grau"),
     *              @OA\Property(property="latitud", type="string", example=1),
     *              @OA\Property(property="longitud", type="string", example=1),
     *              @OA\Property(property="empresa_id", type="number", example=1),
     *              @OA\Property(property="departamento_id", type="number", example=1),
     *              @OA\Property(property="provincia_id", type="number", example=1),
     *              @OA\Property(property="distrito_id", type="number", example=1),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="empresa",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="logo", type="file", example=null),
     *                      @OA\Property(property="responsable", type="string", example=null),
     *                      @OA\Property(property="nombre_comercial", type="string", example=null),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="Documento Nacional de Identidad"),
     *                      @OA\Property(property="razon_social", type="string", example="PE"),
     *                      @OA\Property(property="direccion", type="string", example="Jr. Girasol"),
     *                      @OA\Property(property="ruc", type="string", example="A"),
     *                      @OA\Property(property="latitud", type="string", example="a"),
     *                      @OA\Property(property="longitud", type="string", example="b"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="tipo_documento",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="nombre", type="string", example="DNI"),
     *                              @OA\Property(property="codigo", type="string", example="PE"),
     *                              @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                          )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="departamento",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="departamento", type="string", example="AMAZONAS"),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="distrito",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="distrito", type="string", example="CHACHAPOYAS"),
     *                      @OA\Property(property="provincia_id", type="number", example=1),
     *                  )
     *              ),
     *              @OA\Property(type="array",property="provincia",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="provincia", type="string", example="CHACHAPOYAS"),
     *                      @OA\Property(property="departamento_id", type="number", example=1),
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
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
            DB::beginTransaction();
            $userempresa = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $local = EmpresaLocal::with('empresa.tipo_documento', 'departamento', 'distrito', 'provincia')
                ->where('empresa_id', $userempresa->user_rol[0]->rol->empresa_id)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $local, "size" => count($local)], 200);
            DB::commit();
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
