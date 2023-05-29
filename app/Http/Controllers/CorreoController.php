<?php

namespace App\Http\Controllers;

use App\Models\Correo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\User;

class CorreoController extends Controller
{
    /**
     * Crea un Correo
     * @OA\POST (
     *     path="/api/correo/create",
     *     summary="Crea un correo con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Correo"},
     *      @OA\Parameter(description="Correo Electrónico",          
     *          @OA\Schema(type="string"),name="correo",in="query",required= true,example=987654321            
     *      ), 
     *      @OA\Parameter(description="Id de la Empresa",          
     *          @OA\Schema(type="number"),name="empresa_id",in="query",required= false,example=1             
     *      ), 
     *      @OA\Parameter(description="Id de la Clinica",          
     *          @OA\Schema(type="number"),name="clinica_id",in="query",required= false,example=1              
     *      ),
     *      @OA\Parameter(description="Id de Bregma",          
     *          @OA\Schema(type="number"),name="bregma_id",in="query",required= false,example=1              
     *      ), 
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="correo", type="string", example=987654321),
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
            $verificador = Correo::where("correo", $request->correo)->first();
            if ($verificador) {
                return response()->json("El correo se encuentra registrado, por favor agrege otro correo");
            } else {
                $correo = Correo::create([
                    "correo" => $request->correo,
                    "empresa_id" => $request->empresa_id,
                    "persona_id" => $persona->persona_id,
                    "clinica_id" => $request->clinica_id,
                    "bregma_id" => $request->bregma_id
                ]);
                DB::commit();
                return response()->json($correo);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error"]);
        }
    }


    /**
     * Actualiza un Correo Electrónico
     * @OA\PUT (
     *     path="/api/correo/update/{id}",
     *     summary="Actualiza un correo con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Correo"},
     *      @OA\Parameter(description="Id del Correo",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Parameter(description="Correo Electronico",          
     *          @OA\Schema(type="string"),name="correo",in="query",required= true,example=987654321            
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
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Correo Electronico actualizado"),
     *          )
     *      ),     
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al crear, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $correo = Correo::find($id);
            if ($correo) {
                $verificador = Correo::where("correo", $request->correo)->first();
                if ($verificador) {
                    return response()->json(["resp" => "EL correo se encuentra registrado, por favor agrege otro correo"]);
                } else {
                    $correo->fill(array(
                        "correo" => $request->correo,
                        "empresa_id" => $request->empresa_id,
                        "persona_id" => $request->persona_id,
                        "clinica_id" => $request->clinica_id,
                        "bregma_id" => $request->bregma_id
                    ));
                    $correo->save();
                    DB::commit();
                    return response()->json(["resp" => "Correo actualizado"]);
                }
            } else {
                return response()->json(["resp" => "Id del Correo no existe"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }


    /**
     * Elimina un Correo Electronico
     * @OA\DELETE (
     *     path="/api/correo/delete/{id}",
     *     summary="Elimina un correo con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Correo"},
     *      @OA\Parameter(description="Id del Correo",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *          ), 
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Correo Electronico eliminado"),
     *          )
     *      ),     
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
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
            $correo = Correo::find($Id);
            if ($correo) {
                $correo->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Correo eliminado"]);
            } else {
                return response()->json(["resp" => "Id del Correo no existe"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Mostrar Correos
     * @OA\GET (
     *     path="/api/correo/show/{Id_persona}",
     *     summary="Muestra los correos con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Correo"},
     *      @OA\Parameter(          
     *          description="Id de la Persona",          
     *          @OA\Schema(type="number"),
     *          name="Id_persona",
     *          in="path",
     *          required= true,
     *          example=1            
     *          ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="correo", type="string", example="987654321"),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(property="empresa_id", type="number", example="1"),
     *              @OA\Property(property="persona_id", type="number", example="1"),
     *              @OA\Property(property="clinica_id", type="number", example="1"),
     *              @OA\Property(property="bregma_id", type="number", example="1"),
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
    public function show($Id_persona)
    {
        try {
            $persona = Persona::find($Id_persona);
            if (!$persona) {
                return response()->json(["Resp" => "Id del usuario erroneo"]);
            } else {
                $correo = Correo::where('persona_id', $Id_persona)->where('estado_registro', 'A')->get();
                return response()->json($correo);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
