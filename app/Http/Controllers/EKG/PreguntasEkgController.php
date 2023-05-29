<?php

namespace App\Http\Controllers\EKG;

use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\PreguntasEkg;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreguntasEkgController extends Controller
{

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Preguntas Enk"
     * @OA\Get (
     *     path="/api/ekg/preguntasekg/get",
     *     summary = "Mostrando Datos de PreguntasEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"PreguntasEkg - EKG"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="descripcion",type="string",example="descripcion_example"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                 )
     *               )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran las preguntas ekg"),
     *          )
     *      )
     * )
     */

    public function index()
    {
        try {
            $pregunta_ekg = PreguntasEkg::where('estado_registro', 'A')->get();
            if(count($pregunta_ekg)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos"]);
            if (!$pregunta_ekg) {
                return response()->json(["error"=> "No se encuentran las preguntas ekg"],400);
            }else {
                return response()->json(["data" => $pregunta_ekg,"size"=>count($pregunta_ekg)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Crear Datos de Preguntas Enk
     * @OA\Post(
     *     path = "/api/ekg/preguntasekg/create",
     *     summary = "Creando Datos de PreguntasEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"PreguntasEkg - EKG"},
     *      @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="La descripción de la pregunta",@OA\Schema(type="string"), name="descripcion", in="query", required=false, example="descripcion_example"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example=1),
     *                      @OA\Property(property="descripcion", type="string", example="descripcion_example"),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="La Pregunta Ekg fue creada correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene acceso")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: La pregunta ekg no se ha creado")
     *             )
     *         )
     * )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();

            if($clinica)
            {
            PreguntasEkg::create([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'descripcion' => $request->descripcion,
            ]);
            DB::commit();
            }else{
            return response()->json(["Error"=>"No tiene acceso"],400);
            }
            return response()->json(["resp" => "La Pregunta Ekg fue creada correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La pregunta ekg no se ha creado" => $e],501);
        }
    }

    /**
     * Modifica Datos de Preguntas Enk
     * @OA\Put(
     *     path = "/api/ekg/preguntasekg/update/{id}",
     *     summary = "Modificando Datos de PreguntasEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"PreguntasEkg - EKG"},
     *      @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="integer")),
     *      @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="La descripción de la pregunta",@OA\Schema(type="string"), name="descripcion", in="query", required=false, example="descripcion_example"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example=1),
     *                      @OA\Property(property="descripcion", type="string", example="descripcion_example"),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Pregunta Ekg actualizada correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="La pregunta ekg no se encuentra activo o no existe")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: La pregunta ekg no se ha actualizado")
     *             )
     *         )
     * )
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $pregunta = PreguntasEkg::where('estado_registro', 'A')->find($id);
            if(!$pregunta){
                return response()->json(["error" => "La pregunta ekg no se encuentra activo o no existe"],400);
            }
            $pregunta->fill([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'descripcion' => $request->descripcion,
                ])->save();
            DB::commit();
            return response()->json(["resp" => "Pregunta Ekg actualizada correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La pregunta ekg no se ha actualizado" => $e],501);
        }
    }

    /**
     * Activar  
     * @OA\Put (
     *     path="/api/ekg/preguntasekg/activate/{id}",
     *     summary = "Activando Datos de PreguntasEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"PreguntasEkg - EKG"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Pregunta Ekg activada correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La pregunta ekg ya está activada"),
     *              )
     *          ),
     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La pregunta ekg no existe"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: La pregunta ekg no se ha activado"),
     *              )
     *          ),
     * )
    */

    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $activate = PreguntasEkg::where('estado_registro', 'I')->find($id);
            $exists = PreguntasEkg::find($id);
            if(!$exists){
                return response()->json(["error"=>"La pregunta ekg no existe"],402);
            }
            if(!$activate){
                return response()->json(["error" => "La pregunta ekg ya está activada"],401);
            }
            $activate->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Pregunta Ekg activada correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: La pregunta ekg no se ha activado" => $e],501);
        }
    }

    /**
     * Delete
     * @OA\Delete (
     *     path="/api/ekg/preguntasekg/delete/{id}",
     *     summary = "Eliminando Datos de PreguntasEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"PreguntasEkg - EKG"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Pregunta Ekg eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La pregunta ekg a eliminar ya está inactivada"),
     *              )
     *          ),
     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="La pregunta ekg a eliminar no se encuentra"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: La pregunta ekg no se ha eliminado"),
     *              )
     *          ),
     * )
     */

     public function destroy($id)
     {
         DB::beginTransaction();
         try {
             $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
             $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
             if($clinica)
             {
                 $registro1 = PreguntasEkg::where('estado_registro', 'I')->find($id);
                 if($registro1) return response()->json(["Error" => "La pregunta ekg a eliminar ya está inactivada"],401);
                 $registro = PreguntasEkg::where('estado_registro', 'A')->find($id);
                 if(!$registro) return response()->json(["Error" => "La pregunta ekg a eliminar no se encuentra"],402);
                 $registro->fill([
                     'estado_registro' => 'I',
                 ])->save();
             }else{
                 return response()->json(["Error"=>"No tiene acceso"]);
             }
             DB::commit();
             return response()->json(["resp" => "Pregunta Ekg eliminada correctamente"],200);
         } catch (Exception $e) {
             DB::rollBack();
             return response()->json(["Error: La pregunta ekg no se ha eliminado" => $e],501);
         }
     }
}