<?php

namespace App\Http\Controllers\Psicologia;

use App\Http\Controllers\Controller;
use App\Models\AccidentesEnfermedades;
use App\Models\Clinica;
use App\Models\DatoOcupacional;
use App\Models\Habitos;
use App\Models\HistoriaFamiliar;
use App\Models\MedidaSeguridad;
use App\Models\MotivoEvaluacion;
use App\Models\OtrasObservaciones;
use App\Models\PrincipalRiesgo;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosOcupacionalesController extends Controller
{
    /**
     * Permite visualizar un listado de todos los registros de la tabla "DatoOcupacional"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/get",
     *     summary = "Mostrando Datos de Datos Ocupacionales",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="historia_familiar_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="habitos_id",type="foreignId",example="1"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *               @OA\Property(type="array", property="clinica_servicio",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="clinica_id",type="foreignId",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Clinica Servicio"),
     *                    @OA\Property(property="icono",type="string",example=null),
     *                    @OA\Property(property="parent_id",type="unsignedBigInteger",example=null),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *               @OA\Property(type="array", property="motivo_evaluacion",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Motivo Evaluacion Ejemplo"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="principales_riesgos",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Principal Riesgo Ejemplo"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="medidas_seguridad",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Medida Seguridad Ejemplo"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="historia_familiar",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Historia Familiar Ejemplo"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="accidentes_enfermedades",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Accidente Enfermedad Ejemplo"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="habitos",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Habitos Ejemplo"),
     *                    @OA\Property(property="estado_registro",type="char",example="A")
     *                 )
     *              ),
     *              @OA\Property(type="array", property="otras_observaciones",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="nombre",type="string",example="Observaciones Ejemplo"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros ocupacionales"),
     *          )
     *      )
     * )
     */
    public function index()
    {
        try {
            $dato_ocupacional = DatoOcupacional::where('estado_registro', 'A')->with('motivo_evaluacion','principales_riesgos','medidas_seguridad','historia_familiar','accidentes_enfermedades','habitos','otras_observaciones')->get();
            if (!$dato_ocupacional) {
                return response()->json(["error"=> "No se encuentran registros ocupacionales"],400);
            }else {
                return response()->json(["data" => $dato_ocupacional,"size"=>count($dato_ocupacional)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

/**
     * Crear Datos de Datos Ocupacionales
     * @OA\Post(
     *     path = "/api/psicologia/datosocupacionales/create",
     *     summary = "Creando Datos de Datos Ocupacionales",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *      @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="El id de la tabla motivo evaluacion",@OA\Schema(type="integer"), name="motivo_evaluacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla principal riesgo",@OA\Schema(type="integer"), name="principales_riesgos_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla medida seguridad",@OA\Schema(type="integer"), name="medidas_seguridad_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla historia familiar",@OA\Schema(type="integer"), name="historia_familiar_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla accidentes enfermedades",@OA\Schema(type="integer"), name="accidentes_enfermedades_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla habitos",@OA\Schema(type="integer"), name="habitos_id", in="query", required=false, example="1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example=1),
     *                      @OA\Property(property="motivo_evaluacion_id", type="integer", example=1),
     *                      @OA\Property(property="principales_riesgos_id", type="integer", example=1),
     *                      @OA\Property(property="medidas_seguridad_id", type="integer", example=1),
     *                      @OA\Property(property="historia_familiar_id", type="integer", example=1),
     *                      @OA\Property(property="accidentes_enfermedades_id", type="integer", example=1),
     *                      @OA\Property(property="habitos_id", type="integer", example=1),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="El dato ocupacional fue creado correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene acceso")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El dato ocupacional no se ha creado")
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
            DatoOcupacional::create([
                //'clinica_servicio_id' => $request->clinica_servicio_id,
                'motivo_evaluacion_id' => $request->motivo_evaluacion_id,
                'principales_riesgos_id' => $request->principales_riesgos_id,
                'medidas_seguridad_id' => $request->medidas_seguridad_id,
                'historia_familiar_id' => $request->historia_familiar_id,
                'accidentes_enfermedades_id' => $request->accidentes_enfermedades_id,
                'habitos_id' => $request->habitos_id,
                'otras_observaciones_id' => $request->otras_observaciones_id,
            ]);
            DB::commit();
            }else{
            return response()->json(["Error"=>"No tiene acceso"],400);
            }
            return response()->json(["resp" => "El dato ocupacional fue creado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato ocupacional no se ha creado" => $e],501);
        }
    }

    /**
     * Modifica Datos de Datos Ocupacionales
     * @OA\Put(
     *     path = "/api/psicologia/datosocupacionales/update/{id}",
     *     summary = "Modificando Datos de Datos Ocupacionales",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *      @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="integer")),
     *      @OA\Parameter(description="El id de la tabla clinica servicio",@OA\Schema(type="integer"), name="clinica_servicio_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="El id de la tabla motivo evaluacion",@OA\Schema(type="integer"), name="motivo_evaluacion_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla principal riesgo",@OA\Schema(type="integer"), name="principales_riesgos_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla medida seguridad",@OA\Schema(type="integer"), name="medidas_seguridad_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla historia familiar",@OA\Schema(type="integer"), name="historia_familiar_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla accidentes enfermedades",@OA\Schema(type="integer"), name="accidentes_enfermedades_id", in="query", required=false, example="1"),
     *      @OA\Parameter(description="El id de la tabla habitos",@OA\Schema(type="integer"), name="habitos_id", in="query", required=false, example="1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="clinica_servicio_id", type="integer", example=1),
     *                      @OA\Property(property="motivo_evaluacion_id", type="integer", example=1),
     *                      @OA\Property(property="principales_riesgos_id", type="integer", example=1),
     *                      @OA\Property(property="medidas_seguridad_id", type="integer", example=1),
     *                      @OA\Property(property="historia_familiar_id", type="integer", example=1),
     *                      @OA\Property(property="accidentes_enfermedades_id", type="integer", example=1),
     *                      @OA\Property(property="habitos_id", type="integer", example=1),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Dato ocupacional actualizado correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="El dato ocupacional no se encuentra activo o no existe")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El dato ocupacional no se ha actualizado")
     *             )
     *         )
     * )
     */

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $dato = DatoOcupacional::where('estado_registro', 'A')->find($id);
            if(!$dato){
                return response()->json(["error" => "El dato ocupacional no se encuentra activo o no existe"],400);
            }
            $dato->fill([
                //'clinica_servicio_id' => $request->clinica_servicio_id,
                'motivo_evaluacion_id' => $request->motivo_evaluacion_id,
                'principales_riesgos_id' => $request->principales_riesgos_id,
                'medidas_seguridad_id' => $request->medidas_seguridad_id,
                'historia_familiar_id' => $request->historia_familiar_id,
                'accidentes_enfermedades_id' => $request->accidentes_enfermedades_id,
                'habitos_id' => $request->habitos_id,
                'otras_observaciones_id' => $request->otras_observaciones_id,
                ])->save();
            DB::commit();
            return response()->json(["resp" => "Dato ocupacional actualizado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato ocupacional no se ha actualizado" => $e],501);
        }
    }

    /**
     * Activar  
     * @OA\Put (
     *     path="/api/psicologia/datosocupacionales/activate/{id}",
     *     summary = "Activando Datos de DatosOcupacionales",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Parameter(description="Ingresar el ID por activar",in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Dato ocupacional activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=404,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El dato ocupacional no existe"),
     *              )
     *          ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El dato ocupacional a activar ya está activado"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El dato ocupacional no se ha activado"),
     *              )
     *          ),
     * )
    */

    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $activate = DatoOcupacional::where('estado_registro', 'I')->find($id);
            $exists = DatoOcupacional::find($id);
            if(!$exists){
                return response()->json(["error"=>"El dato ocupacional no existe"],404);
            }
            if(!$activate){
                return response()->json(["error" => "El dato ocupacional a activar ya está activado"],401);
            }
            $activate->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Dato ocupacional activado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato ocupacional no se ha activado" => $e],501);
        }
    }

    /**
     * Delete
     * @OA\Delete (
     *     path="/api/psicologia/datosocupacionales/delete/{id}",
     *     summary = "Eliminando Datos de Datos Ocupacionales",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Parameter(description="Ingresar el ID por eliminar",in="path",name="id",required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Dato ocupacional eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El dato ocupacional a eliminar ya está inactivado"),
     *              )
     *          ),
     *     @OA\Response(response=404,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El antecente ginecológico no existe"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El dato ocupacional no se ha eliminado"),
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
                 $registro1 = DatoOcupacional::where('estado_registro', 'I')->find($id);
                 if($registro1) return response()->json(["Error" => "El dato ocupacional a eliminar ya está inactivado"],401);
                 $registro = DatoOcupacional::where('estado_registro', 'A')->find($id);
                 if(!$registro) return response()->json(["Error" => "El dato ocupacional a eliminar no se encuentra"],404);
                 $registro->fill([
                     'estado_registro' => 'I',
                 ])->save();
             }else{
                 return response()->json(["Error"=>"No tiene acceso"]);
             }
             DB::commit();
             return response()->json(["resp" => "Dato ocupacional eliminado correctamente"],200);
         } catch (Exception $e) {
             DB::rollBack();
             return response()->json(["Error: El dato ocupacional no se ha eliminado" => $e],501);
         }
     }
    
    /**
     * Permite visualizar un listado de todos los registros de la tabla "Motivo Evaluación"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/getmotivoev",
     *     summary = "Mostrando Datos de Motivos de Evaluación",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Motivo Evaluacion Ejemplo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="DatoOcupacional",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"),
     *                    @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"),
     *                    @OA\Property(property="historia_familiar_id",type="foreignId",example="1"),
     *                    @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"),
     *                    @OA\Property(property="habitos_id",type="foreignId",example="1"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros del motivo de la evaluación"),
     *          )
     *      )
     * )
     */

    public function getMotivoEv()
    {
        try {
            $motivo_evaluacion = MotivoEvaluacion::where('estado_registro', 'A')->with('DatoOcupacional')->get();
            if (!$motivo_evaluacion) {
                return response()->json(["error"=> "No se encuentran registros del motivo de la evaluación"],400);
            }else {
                return response()->json(["data" => $motivo_evaluacion,"size"=>count($motivo_evaluacion)]);
            }  
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Principal Riesgo"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/getprincipalri",
     *     summary = "Mostrando Datos de Principales Riesgos",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Principal Riesgo Ejemplo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="DatoOcupacional",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"),
     *                    @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"),
     *                    @OA\Property(property="historia_familiar_id",type="foreignId",example="1"),
     *                    @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"),
     *                    @OA\Property(property="habitos_id",type="foreignId",example="1"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros del principal riesgo"),
     *          )
     *      )
     * )
     */

    public function getPrincipalRi()
    {
        try {
            $principal_riesgo = PrincipalRiesgo::where('estado_registro', 'A')->with('DatoOcupacional')->get();
            if (!$principal_riesgo) {
                return response()->json(["error"=> "No se encuentran registros del principal riesgo"],400);
            }else {
                return response()->json(["data" => $principal_riesgo,"size"=>count($principal_riesgo)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Medida y Seguridad"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/getmedidaseg",
     *     summary = "Mostrando Datos de Medidas y Seguridad",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Medida Seguridad Ejemplo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="DatoOcupacional",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"),
     *                    @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"),
     *                    @OA\Property(property="historia_familiar_id",type="foreignId",example="1"),
     *                    @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"),
     *                    @OA\Property(property="habitos_id",type="foreignId",example="1"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de la medida de seguridad"),
     *          )
     *      )
     * )
     */

    public function getMedidaSeg()
    {
        try {
            $medida_seguridad = MedidaSeguridad::where('estado_registro', 'A')->with('DatoOcupacional')->get();
            if (!$medida_seguridad) {
                return response()->json(["error"=> "No se encuentran registros de la medida de seguridad"],400);
            }else {
                return response()->json(["data" => $medida_seguridad,"size"=>count($medida_seguridad)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }
    
    /**
     * Permite visualizar un listado de todos los registros de la tabla "Historia Familiar"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/gethistoriafam",
     *     summary = "Mostrando Datos de Historia Familiar",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Historia Familiar Ejemplo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="DatoOcupacional",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"),
     *                    @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"),
     *                    @OA\Property(property="historia_familiar_id",type="foreignId",example="1"),
     *                    @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"),
     *                    @OA\Property(property="habitos_id",type="foreignId",example="1"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de la historia familiar"),
     *          )
     *      )
     * )
     */
    
    public function getHistoriaFam()
    {
        try {
            $historia_familiar = HistoriaFamiliar::where('estado_registro', 'A')->with('DatoOcupacional')->get();
            if (!$historia_familiar) {
                return response()->json(["error"=> "No se encuentran registros de la historia familiar"],400);
            }else {
                return response()->json(["data" => $historia_familiar,"size"=>count($historia_familiar)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Accidentes y Enfermedades"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/getaccidentesenf",
     *     summary = "Mostrando Datos de Accidentes y Enfermedades",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Accidentes Enfermedades Ejemplo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="DatoOcupacional",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"),
     *                    @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"),
     *                    @OA\Property(property="historia_familiar_id",type="foreignId",example="1"),
     *                    @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"),
     *                    @OA\Property(property="habitos_id",type="foreignId",example="1"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de los accidentes y enfermedades"),
     *          )
     *      )
     * )
     */

    public function getAccidentesEnf()
    {
        try {
            $accidentes_enfermedades = AccidentesEnfermedades::where('estado_registro', 'A')->with('DatoOcupacional')->get();
            if (!$accidentes_enfermedades) {
                return response()->json(["error"=> "No se encuentran registros de los accidentes y enfermedades"],400);
            }else {
                return response()->json(["data" => $accidentes_enfermedades,"size"=>count($accidentes_enfermedades)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Habitos"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/gethabitos",
     *     summary = "Mostrando Datos de Hábitos",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Habitos Ejemplo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="DatoOcupacional",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"),
     *                    @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"),
     *                    @OA\Property(property="historia_familiar_id",type="foreignId",example="1"),
     *                    @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"),
     *                    @OA\Property(property="habitos_id",type="foreignId",example="1"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de los hábitos"),
     *          )
     *      )
     * )
     */

    public function getHabitos()
    {
        try {
            $habitos = Habitos::where('estado_registro', 'A')->with('DatoOcupacional')->get();
            if (!$habitos) {
                return response()->json(["error"=> "No se encuentran registros de los hábitos"],400);
            }else {
                return response()->json(["data" => $habitos,"size"=>count($habitos)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Otras Observaciones"
     * @OA\Get (
     *     path="/api/psicologia/datosocupacionales/getotrasobs",
     *     summary = "Mostrando Datos de Otras Observaciones",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosOcupacionales - Psicologia"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="nombre",type="string",example="Otras Observaciones Ejemplo"
     *                     ),
     *                     @OA\Property(property="estado_registro",type="char",example="A"
     *                     ),
     *              @OA\Property(type="array", property="DatoOcupacional",
     *                @OA\Items(type="object",
     *                    @OA\Property(property="id",type="integer",example="1"),
     *                    @OA\Property(property="clinica_servicio_id",type="foreignId",example="1"),
     *                    @OA\Property(property="motivo_evaluacion_id",type="foreignId",example="1"),
     *                    @OA\Property(property="principales_riesgos_id",type="foreignId",example="1"),
     *                    @OA\Property(property="medidas_seguridad_id",type="foreignId",example="1"),
     *                    @OA\Property(property="historia_familiar_id",type="foreignId",example="1"),
     *                    @OA\Property(property="accidentes_enfermedades_id",type="foreignId",example="1"),
     *                    @OA\Property(property="habitos_id",type="foreignId",example="1"),
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros de las otras observaciones"),
     *          )
     *      )
     * )
     */

    public function getOtrasObs()
    {
        try {
            $otras_observaciones = OtrasObservaciones::where('estado_registro', 'A')->with('DatoOcupacional')->get();
            if (!$otras_observaciones) {
                return response()->json(["error"=> "No se encuentran registros de las otras observaciones"],400);
            }else {
                return response()->json(["data" => $otras_observaciones,"size"=>count($otras_observaciones)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }
}
