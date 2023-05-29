<?php

namespace App\Http\Controllers;


use App\Models\Celular;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\User;

class CelularController extends Controller
{
    /**
     * Crea un Numero de Celular
     * @OA\POST (
     *     path="/api/celular/create",
     *     summary="Crea un numero de celular con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Celular"},
     *      @OA\Parameter(description="Numero de Celular",
     *          @OA\Schema(type="number"),name="celular",in="query",required= true,example=987654321
     *      ),
     *      @OA\Parameter( description="Id de la Empresa",
     *          @OA\Schema(type="number"),name="empresa_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Id de la Clinica",
     *          @OA\Schema(type="number"),name="clinica_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Id de Bregma",
     *          @OA\Schema(type="number"),name="bregma_id",in="query",required= false,example=1
     *       ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="celular", type="number", example=987654321),
     *              @OA\Property(property="estado_registro", type="char", example="A"),
     *              @OA\Property(property="empresa_id", type="char", example=1),
     *              @OA\Property(property="persona_id", type="number", example=1),
     *              @OA\Property(property="clinica_id", type="number", example=1),
     *              @OA\Property(property="bregma_id", type="number", example=1),
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
            $persona = User::first("persona_id");
            //return response()->json($persona);
            $verificador = Celular::where("celular", $request->celular)->first();
            if ($verificador) {
                return response()->json("EL numero de celular se encuentra registrado, por favor agrege otro numero");
            } else {
                $celular = Celular::create([
                    "celular" => $request->celular,
                    // "empresa_id" => $request->empresa_id,
                    "persona_id" => $persona->persona_id,
                    // "clinica_id" => $request->clinica_id,
                    // "bregma_id" => $request->bregma_id
                ]);
                DB::commit();
                return response()->json($celular);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error"]);
        }
    }

    /**
     * Actualiza un Numero de Celular
     * @OA\PUT (
     *     path="/api/celular/update/{id}",
     *     summary="Actualiza un numero de celular con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Celular"},
     *      @OA\Parameter(description="Id del Celular",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Parameter(description="Numero de Celular",
     *          @OA\Schema(type="number"),name="celular",in="query",required= true,example=987654321
     *      ),
     *      @OA\Parameter(description="Id de la Empresa",
     *          @OA\Schema(type="number"),name="empresa_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Id de la Persona",
     *          @OA\Schema(type="number"),name="persona_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Id de la Clinica",
     *          @OA\Schema(type="number"),name="clinica_id",in="query",required= false,example=1
     *      ),
     *      @OA\Parameter(description="Id de Bregma",
     *          @OA\Schema(type="number"),name="bregma_id",in="query",required= false,example=1
     *       ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Numero de Celular actualizado"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $celular = Celular::find($id);
            if ($celular) {
                $verificador = Celular::where("celular", $request->celular)->first();
                if ($verificador) {
                    return response()->json(["resp" => "EL numero de celular se encuentra registrado, por favor agrege otro numero"]);
                } else {
                    $celular->fill(array(
                        "celular" => $request->celular,
                        // "empresa_id" => $request->empresa_id,
                        "persona_id" => $request->persona_id,
                        // "clinica_id" => $request->clinica_id,
                        // "bregma_id" => $request->bregma_id
                    ));
                    $celular->save();
                    DB::commit();
                    return response()->json(["resp" => "Numero de Celular actualizado"]);
                }
            } else {
                return response()->json(["resp" => "Id del Celular no existe"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }


    /**
     * Elimina un Numero de Celular
     * @OA\DELETE (
     *     path="/api/celular/delete/{id}",
     *     summary="Elimina un numero de celular con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Celular"},
     *      @OA\Parameter( description="Id del Celular",
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Numero de Celular eliminado"),
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
            $celular = Celular::find($Id);
            if ($celular) {
                $celular->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Numero de Celular eliminado"]);
            } else {
                return response()->json(["resp" => "Id del Celular no existe"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Mostrar un Numero de Celular
     * @OA\GET (
     *     path="/api/celular/show/{Id_persona}",
     *     summary="Muestra los numeros de celular con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Celular"},
     *      @OA\Parameter(description="Id de la Persona",
     *          @OA\Schema(type="number"),name="Id_persona",in="path",required= true,example=1
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="celular", type="number", example="987654321"),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(property="empresa_id", type="number", example="1"),
     *              @OA\Property(property="persona_id", type="number", example="1"),
     *              @OA\Property(property="clinica_id", type="number", example="1"),
     *              @OA\Property(property="bregma_id", type="number", example="1"),
     *          )
     *      ),
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function show($Id_persona)
    {
        try {
            $persona = Persona::find($Id_persona);
            if (!$persona) {
                return response()->json(["Resp" => "Id del usuario erroneo"]);
            } else {
                $celular = Celular::where('persona_id', $Id_persona)->where('estado_registro', 'A')->get();
                return response()->json($celular);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}

