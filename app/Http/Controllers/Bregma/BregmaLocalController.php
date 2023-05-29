<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\BregmaLocal;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class BregmaLocalController extends Controller
{
    /**
     *  Crea un local Bregma
     *  @OA\Post (
     *      path="/api/bregma/local/create",
     *      summary="Crea un local de Bregma con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Local"},
     *      @OA\Parameter(description="nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Direecion del Local",
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
     *      @OA\Response(response=206,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Datos de bregma Local creada"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear, intentelo de nuevo"),
     *          )
     *      ),
     *  )
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            /*if (strlen($request->nombre) == 0) return response()->json(["resp" => "No ingreso el nombre del local"]);
            if (strlen($request->direccion) == 0) return response()->json(["resp" => "No ingreso direccion"]);
            if (strlen($request->latitud) == 0) return response()->json(["resp" => "No ingreso latitud"]);
            if (strlen($request->longitud) == 0) return response()->json(["resp" => "No ingreso longitud"]);
            if (strlen($request->departamento_id) == 0) return response()->json(["resp" => "No ingreso departamento"]);
            if (strlen($request->provincia_id) == 0) return response()->json(["resp" => "No ingreso provincia"]);
            if (strlen($request->distrito_id) == 0) return response()->json(["resp" => "No ingreso distrito"]);*/
            BregmaLocal::create([
                "nombre" => $request->nombre,
                "direccion" => $request->direccion,
                "latitud" => $request->latitud,
                "longitud" =>  $request->longitud,
                "departamento_id" =>  $request->departamento_id,
                "provincia_id" =>  $request->provincia_id,
                "distrito_id" =>  $request->distrito_id,
                "bregma_id" => $userbregma->user_rol[0]->rol->bregma_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Datos de Bregma Local creada"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     *  Actualiza un Local Bregma
     *  @OA\Put (
     *      path="/api/bregma/local/update/{id}",
     *      summary="Actualiza un local con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Bregma - Local"},
     *      @OA\Parameter(description="Id",
     *          @OA\Schema(type="number"),name="id",in="path",required= true
     *      ),
     *      @OA\Parameter(description="nombre",
     *          @OA\Schema(type="string"),name="nombre",in="query",required= true
     *      ),
     *      @OA\Parameter(description="Direecion del Local",
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
     *  )
     */
    public function update(Request $request, $IdLocalBregma)
    {
        DB::beginTransaction();
        try {
            $bregmalocal = BregmaLocal::find($IdLocalBregma);
            /*if (strlen($request->nombre) == 0) return response()->json(["resp" => "No ingreso el nombre del local"]);
            if (strlen($request->direccion) == 0) return response()->json(["resp" => "No ingreso direccion"]);
            if (strlen($request->latitud) == 0) return response()->json(["resp" => "No ingreso latitud"]);
            if (strlen($request->longitud) == 0) return response()->json(["resp" => "No ingreso longitud"]);
            if (strlen($request->departamento_id) == 0) return response()->json(["resp" => "No ingreso departamento"]);
            if (strlen($request->provincia_id) == 0) return response()->json(["resp" => "No ingreso provincia"]);
            if (strlen($request->distrito_id) == 0) return response()->json(["resp" => "No ingreso distrito"]);*/
            $bregmalocal->fill(array(
                "nombre" => $request->nombre,
                "direccion" => $request->direccion,
                "latitud" => $request->latitud,
                "longitud" =>  $request->longitud,
                "departamento_id" =>  $request->departamento_id,
                "provincia_id" =>  $request->provincia_id,
                "distrito_id" =>  $request->distrito_id,
            ));
            $bregmalocal->save();
            DB::commit();
            return response()->json(["resp" => "Local actualizado"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Elimina un Local
     * @OA\DELETE (
     *     path="/api/bregma/local/delete/{id}",
     *     summary="Elimina un local con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Local"},
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
            $local = BregmaLocal::find($Id);
            if ($local) {
                $local->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Local eliminado"]);
            } else {
                return response()->json(["resp" => "Id del Local no existe"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Mostrar Locales
     * @OA\GET (
     *     path="/api/bregma/local/show",
     *     summary="Muestra los locales con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Bregma - Local"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="Juan"),
     *              @OA\Property(property="direccion", type="string", example="AV. Grau"),
     *              @OA\Property(property="latitud", type="string", example=1),
     *              @OA\Property(property="longitud", type="string", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(property="departamento_id", type="number", example=1),
     *              @OA\Property(property="provincia_id", type="number", example=1),
     *              @OA\Property(property="distrito_id", type="number", example=1),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="bregma",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="Documento Nacional de Identidad"),
     *                      @OA\Property(property="razon_social", type="string", example="PE"),
     *                      @OA\Property(property="direccion", type="string", example="Jr. Girasol"),
     *                      @OA\Property(property="estado_pago", type="string", example="A"),
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
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregmalocal = BregmaLocal::with(
                'bregma',
                'departamento',
                'distrito',
                'provincia'
            )->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)
                ->where('estado_registro', 'A')
                ->get();
            if (!$bregmalocal) return response()->json(["resp" => "El bregma logeado no tiene local"], 400);
            return response()->json(["data" => $bregmalocal, "size" => count($bregmalocal)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
