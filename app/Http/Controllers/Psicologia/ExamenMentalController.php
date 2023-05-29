<?php

namespace App\Http\Controllers\Psicologia;

use App\Http\Controllers\Controller;
use App\Models\Articulacion;
use App\Models\Clinica;
use App\Models\CoordinacionVisomotriz;
use App\Models\Espacio;
use App\Models\ExamenMental;
use App\Models\PersonaMental;
use App\Models\Postura;
use App\Models\Presentacion;
use App\Models\Ritmo;
use App\Models\Tiempo;
use App\Models\Tono;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamenMentalController extends Controller
{
    /**
     * Permite visualizar un listado de todos los registros de la tabla "ExamenMental"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/get",
     *     summary = "Mostrando Datos de ExamenMental",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="presentacion_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="postura_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="ritmo_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="tono_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="articulacion_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="tiempo_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="espacio_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="persona_mental_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *               @OA\Property(type="array", property="clinica_servicio",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="servicio_id",type="foreignId",example=null),
     *                    @OA\Property(property="clinica_id",type="foreignId",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Padre General 1"),
     *                    @OA\Property(property="icono",type="string",example=null),
     *                    @OA\Property(property="parent_id",type="unsignedBigInteger",example=null),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *               @OA\Property(type="array", property="presentacion",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Adecuado"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="postura",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Erguida"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="ritmo",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="2"),
     *                    @OA\Property(property="nombre",type="string",example="Rapido"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="tono",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Bajo"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="articulacion",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Con dificultad"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="tiempo",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="tipo_tiempo_id",type="integer",example="1"),
     *                    @OA\Property(property="cantidad",type="string",example="10"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="espacio",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Orientado"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="persona_mental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Orientado"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="coordinacion_visomotriz",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Lento"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de examen mental"),
     *          )
     *      )
     * )
     */
    public function index()
    {
        try {
            $examen_mental = ExamenMental::where('estado_registro', 'A')->with('clinica_servicio','presentacion','postura','ritmo','tono','articulacion','tiempo','espacio','persona_mental','coordinacion_visomotriz')->get();
            if (!$examen_mental) {
                return response()->json(["error"=> "No se encuentran registros de examen mental"],400);
            }else {
                return response()->json(["data" => $examen_mental,"size"=>count($examen_mental)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }
    /**
     * Crear Datos de Datos Ocupacionales
     * @OA\Post(
     *     path = "/api/psicologia/examenMental/create",
     *     summary = "Creando Datos de Examen Mental",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *      @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="El id de la tabla presentacion",@OA\Schema(type="integer"), name="presentacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla postura",@OA\Schema(type="integer"), name="postura_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla ritmo",@OA\Schema(type="integer"), name="ritmo_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla tono",@OA\Schema(type="integer"), name="tono_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla articulacion",@OA\Schema(type="integer"), name="articulacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla tiempo",@OA\Schema(type="integer"), name="tiempo_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla espacio",@OA\Schema(type="integer"), name="espacio_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla persona mental",@OA\Schema(type="integer"), name="persona_mental_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla coordinacion visomotriz",@OA\Schema(type="integer"), name="coordinacion_visomotriz_id", in="query", required=false, example="1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer"),
     *                      @OA\Property(property="presentacion_id", type="integer"),
     *                      @OA\Property(property="postura_id", type="integer"),
     *                      @OA\Property(property="ritmo_id", type="integer"),
     *                      @OA\Property(property="tono_id", type="integer"),
     *                      @OA\Property(property="articulacion_id", type="integer"),
     *                      @OA\Property(property="tiempo_id", type="integer"),
     *                      @OA\Property(property="espacio_id", type="integer"),
     *                      @OA\Property(property="persona_mental_id", type="integer"),
     *                      @OA\Property(property="coordinacion_visomotriz_id", type="integer"),
     *                  ),
     *                  example={
     *                              "clinica_servicio_id":1,
     *                              "presentacion_id":1,
     *                              "postura_id":1,
     *                              "ritmo_id":2,
     *                              "tono_id":1,
     *                              "articulacion_id":1,
     *                              "tiempo_id":1,
     *                              "espacio_id":1,
     *                              "persona_mental_id":1,
     *                              "coordinacion_visomotriz_id":1
     *                          }
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="El examen mental fue creado correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene acceso")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El examen mental no se ha creado")
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
                ExamenMental::create([
                'clinica_servicio_id' => $request->clinica_servicio_id,
                'presentacion_id' => $request->presentacion_id,
                'postura_id' => $request->postura_id,
                'ritmo_id' => $request->ritmo_id,
                'tono_id' => $request->tono_id,
                'articulacion_id' => $request->articulacion_id,
                'tiempo_id' => $request->tiempo_id,
                'espacio_id' => $request->espacio_id,
                'persona_mental_id' => $request->persona_mental_id,
                'coordinacion_visomotriz_id' => $request->coordinacion_visomotriz_id,
                ]);
            DB::commit();
            }else{
            return response()->json(["Error"=>"No tiene acceso"]);
            }
            return response()->json(["resp" => "El examen mental fue creado correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El examen mental no se ha creado" => $e]);
        }
    }
    /**
     * Modifica Datos de Datos Ocupacionales
     * @OA\Put(
     *     path = "/api/psicologia/examenMental/update/{id}",
     *     summary = "Modificando Datos de Examen mental",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *      @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="integer")),
      *     @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="El id de la tabla presentacion",@OA\Schema(type="integer"), name="presentacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla postura",@OA\Schema(type="integer"), name="postura_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla ritmo",@OA\Schema(type="integer"), name="ritmo_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla tono",@OA\Schema(type="integer"), name="tono_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla articulacion",@OA\Schema(type="integer"), name="articulacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla tiempo",@OA\Schema(type="integer"), name="tiempo_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla espacio",@OA\Schema(type="integer"), name="espacio_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla persona mental",@OA\Schema(type="integer"), name="persona_mental_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla coordinacion visomotriz",@OA\Schema(type="integer"), name="coordinacion_visomotriz_id", in="query", required=false, example="1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer"),
     *                      @OA\Property(property="presentacion_id", type="integer"),
     *                      @OA\Property(property="postura_id", type="integer"),
     *                      @OA\Property(property="ritmo_id", type="integer"),
     *                      @OA\Property(property="tono_id", type="integer"),
     *                      @OA\Property(property="articulacion_id", type="integer"),
     *                      @OA\Property(property="tiempo_id", type="integer"),
     *                      @OA\Property(property="espacio_id", type="integer"),
     *                      @OA\Property(property="persona_mental_id", type="integer"),
     *                      @OA\Property(property="coordinacion_visomotriz_id", type="integer"),
     *                  ),
     *                  example={
     *                              "clinica_servicio_id":1,
     *                              "presentacion_id":1,
     *                              "postura_id":1,
     *                              "ritmo_id":1,
     *                              "tono_id":1,
     *                              "articulacion_id":1,
     *                              "tiempo_id":1,
     *                              "espacio_id":1,
     *                              "persona_mental_id":1,
     *                              "coordinacion_visomotriz_id":1
     *                          }
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Examen mental actualizado correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="El examen mental no se encuentra activo o no existe")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El examen mental no se ha actualizado")
     *             )
     *         )
     * )
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $dato = ExamenMental::where('estado_registro', 'A')->find($id);
            if(!$dato){
                return response()->json(["error" => "El examen mental no se encuentra activo o no existe"],400);
            }
            $dato->fill([
                    'servicio_clinica_id' => $request->servicio_clinica_id,
                    'presentacion_id' => $request->presentacion_id,
                    'postura_id' => $request->postura_id,
                    'ritmo_id' => $request->ritmo_id,
                    'tono_id' => $request->tono_id,
                    'articulacion_id' => $request->articulacion_id,
                    'tiempo_id' => $request->tiempo_id,
                    'espacio_id' => $request->espacio_id,
                    'persona_id' => $request->persona_id,
                    'coordinacion_visomotriz_id' => $request->coordinacion_visomotriz_id
                ])->save();
            DB::commit();
            return response()->json(["resp" => "examen mental actualizado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El examen mental no se ha actualizado" => $e],501);
        }
    }
/**
     * Activar
     * @OA\Put (
     *     path="/api/psicologia/examenMental/activate/{id}",
     *     summary = "Activando Datos de Examen mental",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Examen mental activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El examen mental no existe"),
     *              )
     *          ),

     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El examen mental a activar ya está activado..."),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: Examen mental no se ha activado"),
     *              )
     *          ),
     * )
*/
    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $activate = ExamenMental::where('estado_registro', 'I')->find($id);
            $exists = ExamenMental::find($id);
            if(!$exists){
                return response()->json(["error"=>"El examen mental no existe"],401);
            }
            if(!$activate){
                return response()->json(["error" => "El examen mental a activar ya está activado..."],402);
            }
            $activate->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Examen mental activado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: Examen mental no se ha activado" => $e],501);
        }
    }
    /**
     * Delete
     * @OA\Delete (
     *     path="/api/psicologia/examenMental/delete/{id}",
     *     summary = "Eliminando Datos de Examen mental",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Examen mental eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El examen mental no existe"),
     *              )
     *          ),
     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El examen mental a eliminar ya está inactivado..."),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: Examen mental no se ha eliminado"),
     *              )
     *          ),
     * )
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = ExamenMental::where('estado_registro', 'A')->find($id);
            $exists = ExamenMental::find($id);
            if(!$exists){
                return response()->json(["error"=>"El examen mental no existe"],401);
            }
            if(!$delete){
                return response()->json(["error" => "El examen mental a eliminar ya está inactivado..."],402);
            }
            $delete->fill([
                'estado_registro' => 'I',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Examen mental eliminado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: Examen mental no se ha eliminado" => $e],501);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Presentacion"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getPresentacion",
     *     summary = "Mostrando Datos de Presentacion",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Adecuado"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de presentacion"),
     *          )
     *      )
     * )
     */

    public function getPresentacion()
    {
        try {
            $presentacion = Presentacion::where('estado_registro', 'A')->get();
            if (!$presentacion) {
                return response()->json(["error"=> "No se encuentran registros de presentacion"],400);
            }else {
                return response()->json(["data" => $presentacion,"size"=>count($presentacion)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Postura"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getPostura",
     *     summary = "Mostrando Datos de Postura",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Erguida"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de postura"),
     *          )
     *      )
     * )
     */


    public function getPostura()
    {
        try {
            $postura = Postura::where('estado_registro', 'A')->get();
            if (!$postura) {
                return response()->json(["error"=> "No se encuentran registros de postura"],400);
            }else {
                return response()->json(["data" => $postura,"size"=>count($postura)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Ritmo"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getRitmo",
     *     summary = "Mostrando Datos de Ritmo",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="2"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Rapido"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de ritmo"),
     *          )
     *      )
     * )
     */

    public function getRitmo()
    {
        try {
            $ritmo = Ritmo::where('estado_registro', 'A')->get();
            if (!$ritmo) {
                return response()->json(["error"=> "No se encuentran registros de ritmo"],400);
            }else {
                return response()->json(["data" => $ritmo,"size"=>count($ritmo)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Tono"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getTono",
     *     summary = "Mostrando Datos de Tono",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Bajo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de tono"),
     *          )
     *      )
     * )
     */

    public function getTono()
    {
        try {
            $tono = Tono::where('estado_registro', 'A')->get();
            if (!$tono) {
                return response()->json(["error"=> "No se encuentran registros de tono"],400);
            }else {
                return response()->json(["data" => $tono,"size"=>count($tono)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Articulacion"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getArticulacion",
     *     summary = "Mostrando Datos de Articulacion",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Con dificultad"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de articulacion"),
     *          )
     *      )
     * )
     */

    public function getArticulacion()
    {
        try {
            $articulacion = Articulacion::where('estado_registro', 'A')->get();
            if (!$articulacion) {
                return response()->json(["error"=> "No se encuentran registros de articulacion"],400);
            }else {
                return response()->json(["data" => $articulacion,"size"=>count($articulacion)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Tiempo"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getTiempo",
     *     summary = "Mostrando Datos de Tiempo",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="tipo_tiempo_id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="cantidad",type="string",example="10"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de tiempo"),
     *          )
     *      )
     * )
     */

    public function getTiempo()
    {
        try {
            $tiempo = Tiempo::where('estado_registro', 'A')->get();
            if (!$tiempo) {
                return response()->json(["error"=> "No se encuentran registros de tiempo"],400);
            }else {
                return response()->json(["data" => $tiempo,"size"=>count($tiempo)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Espacio"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getEspacio",
     *     summary = "Mostrando Datos de Espacio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Orientado"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de espacio"),
     *          )
     *      )
     * )
     */

    public function getEspacio()
    {
        try {
            $espacio = Espacio::where('estado_registro', 'A')->get();
            if (!$espacio) {
                return response()->json(["error"=> "No se encuentran registros de espacio"],400);
            }else {
                return response()->json(["data" => $espacio,"size"=>count($espacio)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "PersonaMental"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getPersonaMental",
     *     summary = "Mostrando Datos de PersonaMental",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Orientado"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de persona mental"),
     *          )
     *      )
     * )
     */

    public function getPersonaMental()
    {
        try {
            $persona_mental = PersonaMental::where('estado_registro', 'A')->get();
            if (!$persona_mental) {
                return response()->json(["error"=> "No se encuentran registros de persona mental"],400);
            }else {
                return response()->json(["data" => $persona_mental,"size"=>count($persona_mental)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "CoordinacionVisomotriz"
     * @OA\Get (
     *     path="/api/psicologia/examenMental/getCoordinacionVisomotriz",
     *     summary = "Mostrando Datos de CoordinacionVisomotriz",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Psicologia - ExamenMental"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Lento"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="ExamenMental",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="presentacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="postura_id",type="foreignId",example="1"),
     *                    @OA\Property(property="ritmo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tono_id",type="foreignId",example="1"),
     *                    @OA\Property(property="articulacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="tiempo_id",type="foreignId",example="1"),
     *                    @OA\Property(property="espacio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="persona_mental_id",type="foreignId",example="1"),
     *                    @OA\Property(property="coordinacion_visomotriz_id",type="foreignId",example="1"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              )
     *              )
     *             ),
     *             @OA\Property(type="count",property="size",example="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de coordinacion visomotriz"),
     *          )
     *      )
     * )
     */

    public function getCoordinacionVisomotriz()
    {
        try {
            $coordinacion_visomotriz = CoordinacionVisomotriz::where('estado_registro', 'A')->get();
            if (!$coordinacion_visomotriz) {
                return response()->json(["error"=> "No se encuentran registros de coordinacion visomotriz"],400);
            }else {
                return response()->json(["data" => $coordinacion_visomotriz,"size"=>count($coordinacion_visomotriz)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }
}
