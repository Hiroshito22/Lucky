<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Contrato;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
{
    /**
     * Crear datos de bregma
     * @OA\Post (
     *     path="/api/contrato/create",
     *     summary="Crear contrato con sesión iniciada",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Contrato"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="id", type="number"),
     *                      @OA\Property(property="bregma_id", type="number"),
     *                      @OA\Property(property="clinica_id", type="number"),
     *                      @OA\Property(property="empresa_id", type="number"),
     *                      @OA\Property(property="fecha_inicio", type="string"),
     *                      @OA\Property(property="fecha_vencimiento", type="string"),
     *                      @OA\Property(property="estado_contrato", type="number"),
     *                      @OA\Property(property="estado_registro", type="char")
     *                 ),
     *                 example={
     *                     "bregma_id": 1,
     *                     "clinica_id": 1,
     *                     "empresa_id": 1,
     *                     "fecha_inicio": "2023-03-26",
     *                     "fecha_vencimiento": "2024-03-26",
     *                     "estado_contrato": 0,
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Parameter(
     *          description="ID del bregma",
     *          @OA\Schema(type="number"),
     *          name="bregma_id",
     *          in="query",
     *          required= true,
     *          example=1
     *      ),
     *      @OA\Parameter(
     *          description="ID de la clinica",
     *          @OA\Schema(type="number"),
     *          name="clinica_id",
     *          in="query",
     *          required= false,
     *      ),
     *      @OA\Parameter(
     *          description="ID de la empresa",
     *          @OA\Schema(type="number"),
     *          name="empresa_id",
     *          in="query",
     *          required= false,
     *      ),
     *      @OA\Parameter(
     *          description="Fecha de inicio del contrato",
     *          @OA\Schema(type="string"),
     *          name="fecha_inicio",
     *          in="query",
     *          required= true,
     *          example="2023-03-06"
     *      ),
     *      @OA\Parameter(
     *          description="Fecha de vencimiento del contrato",
     *          @OA\Schema(type="string"),
     *          name="fecha_vencimiento",
     *          in="query",
     *          required= true,
     *          example="2024-03-06"
     *      ),
     *      @OA\Parameter(
     *          description="Numero de estado en el que se encuentra el pago",
     *          @OA\Schema(type="number"),
     *          name="estado_contrato",
     *          in="query",
     *          required= true,
     *          example=0
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Datos de Bregma creada"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el id de un Bregma"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el id de una Clinica"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=402,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el id de una empresa"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso la fecha de inicio"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso la fecha de vencimiento"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=405,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el estado del contrato"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if (strlen($request->bregma_id) == 0) return response()->json("No ingreso el id de un Bregma");
            if (strlen($request->clinica_id) == 0) return response()->json("No ingreso el id de una clinica");
            // if (strlen($request->empresa_id) == 0) return response()->json("No ingreso el id de una empresa");
            // if (strlen($request->fecha_inicio)) return response()->json("No ingreso la fecha de inicio");
            // if (strlen($request->fecha_vencimiento)) return response()->json("No ingreso la fecha de vencimiento");
            // if (strlen($request->estado_contrato)) return response()->json("No ingreso el estado del contrato");
            $contrato = Contrato::create([
                "bregma_id" => $request->bregma_id,
                "clinica_id" => $request->clinica_id == 0 ? null : $request->clinica_id,
                "empresa_id" => $request->empresa_id == 0 ? null : $request->empresa_id,
                "fecha_inicio" => $request->fecha_inicio == "" ? null : $request->fecha_inicio,
                "fecha_vencimiento" => $request->fecha_vencimiento == "" ? null : $request->fecha_vencimiento,
                "estado_contrato" => $request->estado_contrato == 0 ? null : $request->estado_contrato,
            ]);
            DB::commit();
            return response()->json(["resp" => "Contrato creado"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     * Actualizar datos de bregma
     * @OA\Put (
     *      path="/api/contrato/update/{id_contrato}",
     *      summary="Crear contrato con sesión iniciada",
     *      security={{ "bearerAuth":{} }},
     *      tags={"Contrato"},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="id", type="number"),
     *                      @OA\Property(property="bregma_id", type="number"),
     *                      @OA\Property(property="clinica_id", type="number"),
     *                      @OA\Property(property="empresa_id", type="number"),
     *                      @OA\Property(property="fecha_inicio", type="string"),
     *                      @OA\Property(property="fecha_vencimiento", type="string"),
     *                      @OA\Property(property="estado_contrato", type="number"),
     *                      @OA\Property(property="estado_registro", type="char")
     *                 ),
     *                 example={
     *                     "bregma_id": 1,
     *                     "clinica_id": 1,
     *                     "empresa_id": 1,
     *                     "fecha_inicio": "2023-03-26",
     *                     "fecha_vencimiento": "2024-03-26",
     *                     "estado_contrato": 0,
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Parameter(
     *          description="ID del contrato",
     *          @OA\Schema(type="number"),
     *          name="id_contrato",
     *          in="path",
     *          required= true,
     *          example=1
     *      ),
     *      @OA\Parameter(
     *          description="ID del bregma",
     *          @OA\Schema(type="number"),
     *          name="bregma_id",
     *          in="query",
     *          required= true,
     *          example=1
     *      ),
     *      @OA\Parameter(
     *          description="ID de la clinica",
     *          @OA\Schema(type="number"),
     *          name="clinica_id",
     *          in="query",
     *          required= false,
     *      ),
     *      @OA\Parameter(
     *          description="ID de la empresa",
     *          @OA\Schema(type="number"),
     *          name="empresa_id",
     *          in="query",
     *          required= false,
     *      ),
     *      @OA\Parameter(
     *          description="Fecha de inicio del contrato",
     *          @OA\Schema(type="string"),
     *          name="fecha_inicio",
     *          in="query",
     *          required= true,
     *          example="2023-03-06"
     *      ),
     *      @OA\Parameter(
     *          description="Fecha de vencimiento del contrato",
     *          @OA\Schema(type="string"),
     *          name="fecha_vencimiento",
     *          in="query",
     *          required= true,
     *          example="2024-03-06"
     *      ),
     *      @OA\Parameter(
     *          description="Numero de estado en el que se encuentra el pago",
     *          @OA\Schema(type="number"),
     *          name="estado_contrato",
     *          in="query",
     *          required= true,
     *          example=0
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Datos de contrato actualizado"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el id de un Bregma"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el id de una Clinica"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=402,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el id de una empresa"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso la fecha de inicio"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso la fecha de vencimiento"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=405,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso el estado del contrato"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=406,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Ya existe otro contrato con el id de la clinica"),
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id_contrato)
    {
        DB::beginTransaction();
        try {
            $contrato = Contrato::find($id_contrato);
            if (strlen($request->bregma_id) == 0) return response()->json("No ingreso el id de un Bregma");
            // if (strlen($request->clinica_id) == 0) return response()->json("No ingreso el id de una clinica");
            // if (strlen($request->empresa_id) == 0) return response()->json("No ingreso el id de una empresa");
            // if (strlen($request->fecha_inicio)) return response()->json("No ingreso la fecha de inicio");
            // if (strlen($request->fecha_vencimiento)) return response()->json("No ingreso la fecha de vencimiento");
            // if (strlen($request->estado_contrato)) return response()->json("No ingreso el estado del contrato");
            // $clinica = Contrato::where('clinica_id', $request->clinica_id)
            //            ->where('id','!=',$id_contrato)
            //            ->where('estado_registro','A')->first();
            // if ($clinica)return response()->json("Ya existe otro contrato con el id de la clinica");
            $contrato->fill([
                "bregma_id" => $request->bregma_id,
                "clinica_id" => $request->clinica_id == 0 ? null : $request->clinica_id,
                "empresa_id" => $request->empresa_id == 0 ? null : $request->empresa_id,
                "fecha_inicio" => $request->fecha_inicio == "" ? null : $request->fecha_inicio,
                "fecha_vencimiento" => $request->fecha_vencimiento == "" ? null : $request->fecha_vencimiento,
                "estado_contrato" => $request->estado_contrato == 0 ? null : $request->estado_contrato,
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Contrato actualizado"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     * Eliminar datos del contrato
     * @OA\Delete (
     *     path="/api/contrato/delete/{id_contrato}",
     *     summary="Inhabilita el registro del contrato teniendo como parametro el id del bregma con sesión iniciada",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Contrato"},
     *      @OA\Parameter(
     *          description = "Numero de ID del registro de bregma que se desea eliminar",
     *          @OA\Schema(type="number"),
     *          name="id_contrato",
     *          in="path",
     *          required= true,
     *          example=2
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *          @OA\Property(property="resp", type="string", example="Datos de Bregma inhabilitadas"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No existen datos con este id"),
     *          )
     *      )
     * )
     */
    public function delete($id_contrato)
    {
        DB::beginTransaction();
        try {
            $contrato = Contrato::find($id_contrato);
            $contrato->fill([
                "estado_registro" => 'I'
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Contrato deshabilitado"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     * Muestra todos los registros de Bregma
     * @OA\Get(
     *     path="/api/contrato/show",
     *     summary="Muestra todos los registros respectivo a la sesión iniciada",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Contrato"},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  type="array",
     *                  property="data",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="bregma_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="empresa_id", type="number", example=1),
     *                      @OA\Property(property="fecha_inicio", type="date", example="2023-03-06"),
     *                      @OA\Property(property="fecha_vencimiento", type="date", example="2023-03-06"),
     *                      @OA\Property(property="estado_contrato", type="char", example=0),
     *                      @OA\Property(property="estado_registro", type="char", example="A")
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
    public function show()
    {
        $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
        if ($user->user_rol[0]->rol->bregma_id) {
            $contratos = Contrato::with('clinica','bregma')
                ->where('bregma_id', $user->user_rol[0]->rol->bregma_id)
                ->get();
        }
        else if ($user->user_rol[0]->rol->clinica_id) {
            $contratos = Contrato::with('clinica','empresa','bregma')
                ->where('clinica_id', $user->user_rol[0]->rol->clinica_id)
                ->get();
        }
        else if ($user->user_rol[0]->rol->empresa_id) {
            $contratos = Contrato::with('clinica','empresa')
                ->where('empresa_id', $user->user_rol[0]->rol->empresa_id)
                ->get();
        }
        return response()->json(["data" => $contratos, "size" => count($contratos)]);
    }
}
