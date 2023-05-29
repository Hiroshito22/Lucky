<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EntidadPago;
use App\User;

class EntidadPagoController extends Controller
{
    /**
     * Crea una entidad bancaria de pago
     * @OA\POST (
     *     path="/api/entidad_pago/create",
     *     summary="Crea los datos de la  entidad con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad"},
     *      @OA\Parameter(
     *          description="id de la persona",
     *          @OA\Schema(type="number"),
     *          name="id_persona",
     *          in="path",
     *          required= true,
     *          example=1
     *          ),
     *      @OA\Parameter(
     *          description="numero_cuenta",
     *          @OA\Schema(type="number"),
     *          name="numero_cuenta",
     *          in="query",
     *          required= true,
     *          example=123456
     *          ),
     *      @OA\Parameter(
     *          description="cci",
     *          @OA\Schema(type="number"),
     *          name="cci",
     *          in="query",
     *          required= true,
     *          example=123456
     *          ),
     *      @OA\Parameter(
     *          description="entidad_bancaria_id",
     *          @OA\Schema(type="number"),
     *          name="entidad_bancaria_id",
     *          in="query",
     *          required= true,
     *          example=1
     *          ),
     *      @OA\Parameter(
     *          description="bregma_id",
     *          @OA\Schema(type="number"),
     *          name="bregma_id",
     *          in="query",
     *          required= true,
     *          ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="numero_cuenta", type="number", example=123456),
     *              @OA\Property(property="cci", type="number", example=123456),
     *              @OA\Property(property="estado_registro", type="char", example="A"),
     *              @OA\Property(property="entidad_bancaria_id", type="number", example=1),
     *              @OA\Property(property="persona_id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
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
            $user = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $verificador_cuenta = EntidadPago::where("numero_cuenta", $request->numero_cuenta)->first();
            $verificador_cci = EntidadPago::where("cci", $request->cci)->first();
            if ($verificador_cuenta || $verificador_cci) {
                return response()->json("EL numero de cuenta o CCI ya estan registradas");
            } else {
                EntidadPago::create([
                    "numero_cuenta" => $request->numero_cuenta,
                    "cci" => $request->cci,
                    "entidad_bancaria_id" => $request->entidad_bancaria_id,
                    "persona_id" =>  $user->persona->id,
                    "bregma_id" => $user->user_rol[0]->rol->bregma_id,
                    "clinica_id" => $user->user_rol[0]->rol->clinica_id,
                    "empresa_id" => $user->user_rol[0]->rol->empresa_id
                ]);
                DB::commit();
                return response()->json("Entidad de Pago creada");
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Actualiza una entidad bancaria de pago
     * @OA\PUT (
     *     path="/api/entidad_pago/update/{id}",
     *     summary="Actualiza los datos de la  entidad con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad"},
     *      @OA\Parameter(
     *          description="id de la entidad para actualizar",
     *          @OA\Schema(type="number"),
     *          name="id",
     *          in="path",
     *          required= true,
     *          example=1
     *          ),
     *      @OA\Parameter(
     *          description="numero_cuenta",
     *          @OA\Schema(type="number"),
     *          name="numero_cuenta",
     *          in="query",
     *          required= true,
     *          example=123456
     *          ),
     *      @OA\Parameter(
     *          description="cci",
     *          @OA\Schema(type="number"),
     *          name="cci",
     *          in="query",
     *          required= true,
     *          example=123456
     *          ),
     *      @OA\Parameter(
     *          description="entidad_bancaria_id",
     *          @OA\Schema(type="number"),
     *          name="entidad_bancaria_id",
     *          in="query",
     *          required= true,
     *          example=1
     *          ),
     *      @OA\Parameter(
     *          description="bregma_id",
     *          @OA\Schema(type="number"),
     *          name="bregma_id",
     *          in="query",
     *          required= true,
     *          ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Entidad de Pago actualizada"),
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

    public function update(Request $request, $Id)
    {
        DB::beginTransaction();
        try {
            $entidad = EntidadPago::find($Id);

            $entidad->fill(array(
                "numero_cuenta" => $request->numero_cuenta,
                "cci" => $request->cci,
                "entidad_bancaria_id" => $request->entidad_bancaria_id,
                "bregma_id" => $entidad->bregma_id
            ));
            $entidad->save();

            DB::commit();
            return response()->json(["resp" => "Entidad actualizada"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    /**
     * Elimina una entidad bancaria de pago
     * @OA\DELETE (
     *     path="/api/entidad_pago/delete/{id}",
     *     summary="Elimina los datos de la  entidad con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad"},
     *      @OA\Parameter(
     *          description="id de la entidad para eliminar",
     *          @OA\Schema(type="number"),
     *          name="id",
     *          in="path",
     *          required= true,
     *          example=1
     *          ),

     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Entidad de Pago eliminada"),

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

    public function delete($Id)
    {
        try {
            DB::beginTransaction();
            $entidad = EntidadPago::find($Id);
            if (!$entidad) {
                return response()->json(["Resp" => "no existe la entidad"]);
            } else {
                $entidad->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "entidad eliminada"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Muestra todas las entidades bancarias de pago
     * @OA\GET (
     *     path="/api/entidad_pago/show/{id_persona}",
     *     summary="Muestra los datos de la  entidad con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad"},
     *      @OA\Parameter(
     *          description="id de la persona",
     *          @OA\Schema(type="number"),
     *          name="id",
     *          in="path",
     *          required= true,
     *          example=1
     *          ),

     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="numero_cuenta", type="number", example=123456),
     *              @OA\Property(property="cci", type="number", example=123456),
     *              @OA\Property(property="estado_registro", type="char", example="A"),
     *              @OA\Property(property="entidad_bancaria_id", type="number", example=1),
     *              @OA\Property(property="persona_id", type="number", example=1),
     *              @OA\Property(type="array",property="entidad_bancaria",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="corportiva"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
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
    public function show()
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $entidad = EntidadPago::with('entidad_bancaria')
                ->where('persona_id', $user->user_rol[0]->rol->persona_id)
                ->orWhere('bregma_id', $user->user_rol[0]->rol->bregma_id)
                ->orWhere('clinica_id', $user->user_rol[0]->rol->clinica_id)
                ->get();
            return response()->json($entidad);
        } catch (Exception $e) {
            return response()->json(["error" => "error" . $e]);
        }
    }


    /**
     * Muestra todas las entidades bancarias de pago
     * @OA\GET (
     *     path="/api/entidad_pago/show-bregma",
     *     summary="Muestra los datos de la  entidad con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Entidad"},
     *      @OA\Parameter(
     *          description="id de la persona",
     *          @OA\Schema(type="number"),
     *          name="id",
     *          in="path",
     *          required= true,
     *          example=1
     *          ),

     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="numero_cuenta", type="number", example=123456),
     *              @OA\Property(property="cci", type="number", example=123456),
     *              @OA\Property(property="estado_registro", type="char", example="A"),
     *              @OA\Property(property="entidad_bancaria_id", type="number", example=1),
     *              @OA\Property(property="persona_id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
     *              @OA\Property(type="array",property="entidad_bancaria",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="BCP"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *
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
    public function showEntidadesPagoBregma()
    {
        try {
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $entidades_pagos = EntidadPago::with('entidad_bancaria')->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)->get();
            if (!$entidades_pagos) return response()->json(["resp" => "El bregma logeado no tiene entidades de pago"], 400);
            return response()->json(["data" => $entidades_pagos, "size" => count($entidades_pagos)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }

    /**
     * Crear entidad pago
     * @OA\Post (
     *    path="/api/entidad_pago/create-bregma",
     *    summary="Crear entidad pago",
     *    security={{ "bearerAuth": {} }},
     *    tags={"Entidad"},
     *    @OA\RequestBody(
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               @OA\Property(
     *                   type="object",
     *                   @OA\Property(property="numero_cuenta",type="number"),
     *                   @OA\Property(property="cci",type="number"),
     *                   @OA\Property(property="entidad_bancaria_id",type="number"),
     *               ),
     *               example={
     *                  "numero_cuenta":123456,
     *                  "cci":123456,
     *                  "entidad_bancaria_id":1
     *               }
     *            )
     *         )
     *    ),
     *    @OA\Parameter(
     *       description="Numero de cuenta",
     *       @OA\Schema(type="number"),
     *       name="numero_cuenta",
     *       in="query",
     *       required=false,
     *       example=123456
     *    ),
     *    @OA\Parameter(
     *       description="Código de cuenta interbancaria (cci)",
     *       @OA\Schema(type="number"),
     *       name="cci",
     *       in="query",
     *       required=false,
     *       example=123456
     *    ),
     *    @OA\Parameter(
     *       description="Id de la entidad bancaria",
     *       @OA\Schema(type="number"),
     *       name="entidad_bancaria_id",
     *       in="query",
     *       required=false,
     *       example=1
     *    ),
     *    @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Entidad pago creadas"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un numero de cuenta"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso un cci de cuenta"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=402,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="No ingreso una entidad bancaria"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="EL numero de cuenta o CCI ya estan registradas"),
     *          )
     *      ),
     * )
     */
    public function createBregma(Request $request)
    {
        DB::beginTransaction();
        try {
            $userbregma = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $verificador_cuenta = EntidadPago::where("numero_cuenta", $request->numero_cuenta)->first();
            $verificador_cci = EntidadPago::where("cci", $request->cci)->first();
            if (strlen($request->numero_cuenta) == 0) return response()->json("No ingreso un numero de cuenta", 400);
            if (strlen($request->cci) == 0) return response()->json("No ingreso un cci de cuenta", 401);
            if (strlen($request->entidad_bancaria_id) == 0) return  response()->json("No ingreso una entidad bancaria", 402);
            if ($verificador_cuenta || $verificador_cci) return response()->json("EL numero de cuenta o CCI ya estan registradas", 403);
            $entidad = EntidadPago::create([
                "numero_cuenta" => $request->numero_cuenta,
                "cci" => $request->cci,
                "entidad_bancaria_id" => $request->entidad_bancaria_id,
                "persona_id" => $userbregma->persona->id,
                "bregma_id" => $userbregma->user_rol[0]->rol->bregma_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Entidad pago creadas"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    public function createClinica(Request $request)
    {
        DB::beginTransaction();
        try {
            $userclinica = User::with('persona', 'user_rol.rol')->where('id', auth()->user()->id)->first();
            $verificador_cuenta = EntidadPago::where("numero_cuenta", $request->numero_cuenta)->first();
            $verificador_cci = EntidadPago::where("cci", $request->cci)->first();
            if (strlen($request->numero_cuenta) == 0) return response()->json("No ingreso un numero de cuenta", 400);
            if (strlen($request->cci) == 0) return response()->json("No ingreso un cci de cuenta", 401);
            if (strlen($request->entidad_bancaria_id) == 0) return  response()->json("No ingreso una entidad bancaria", 402);
            if ($verificador_cuenta || $verificador_cci) return response()->json("EL numero de cuenta o CCI ya estan registradas", 403);
            EntidadPago::create([
                "numero_cuenta" => $request->numero_cuenta,
                "cci" => $request->cci,
                "entidad_bancaria_id" => $request->entidad_bancaria_id,
                "persona_id" => $userclinica->persona->id,
                "clinica_id" => $userclinica->user_rol[0]->rol->clinica_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Entidad pago creadas"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "Error" . $e]);
        }
    }
}
