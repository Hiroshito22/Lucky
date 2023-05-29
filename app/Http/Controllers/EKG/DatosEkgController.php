<?php

namespace App\Http\Controllers\EKG;

use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\DatosEkg;
use App\Models\Ekg;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosEkgController extends Controller
{

    /**
     * Permite visualizar un listado de todos los registros de la tabla "Datos Ekg"
     * @OA\Get (
     *     path="/api/ekg/datosekg/get",
     *     summary = "Mostrando Datos de DatosEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosEkg - EKG"},
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(type="array", property="data",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"
     *                     ),
     *                     @OA\Property(property="ritmo",type="string",example="95 o más"
     *                     ),
     *                     @OA\Property(property="pr",type="double",example="0.1"
     *                     ),
     *                     @OA\Property(property="frecuencia",type="string",example="Entre 80 - 70"
     *                     ),
     *                     @OA\Property(property="qrs",type="double",example="0.07"
     *                     ),
     *                     @OA\Property(property="eje_electrico",type="integer",example="-10"
     *                     ),
     *                     @OA\Property(property="qt",type="double",example="440"
     *                     ),
     *                     @OA\Property(property="conclusiones",type="string",example="conclusiones_example"
     *                     ),
     *                     @OA\Property(property="recomendaciones",type="string",example="recomendaciones_example"
     *                     ),
     *                     @OA\Property(property="medico_evaluador",type="string",example="medico_evaluador_example"
     *                     ),
     *                     @OA\Property(property="colegiatura",type="string",example="colegiatura_example"
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
     *              @OA\Property(property="error", type="string", example="No se encuentran registros ocupacionales"),
     *          )
     *      )
     * )
     */
    public function index()
    {
        try {
            $dato_ekg = DatosEkg::where('estado_registro', 'A')->get();
            if(count($dato_ekg)==0) return response()->json(["Error"=>"Por ahora no hay Registros Activos"]);
            if (!$dato_ekg) {
                return response()->json(["error"=> "No se encuentran los datos ekg"],400);
            }else {
                return response()->json(["data" => $dato_ekg,"size"=>count($dato_ekg)]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error " . $e]);
        }
    }

    /**
     * Crear Datos de Datos Ekg
     * @OA\Post(
     *     path = "/api/ekg/datosekg/create",
     *     summary = "Creando Datos de DatosEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosEkg - EKG"},
     *      @OA\Parameter(description="El ritmo cardiaco del paciente",@OA\Schema(type="string"), name="ritmo", in="query", required=false, example="95 o más"),
     *      @OA\Parameter(description="El P.R. del paciente",@OA\Schema(type="double"), name="pr", in="query", required=false, example="0.1"),
     *      @OA\Parameter(description="La frecuencia cardiaca del paciente",@OA\Schema(type="string"), name="frecuencia", in="query", required=false, example="Entre 80 - 70"),
     *      @OA\Parameter(description="El Q.R.S. del paciente",@OA\Schema(type="double"), name="qrs", in="query", required=false, example="0.07"),
     *      @OA\Parameter(description="El eje eléctrico del paciente",@OA\Schema(type="integer"), name="eje_electrico", in="query", required=false, example="-10"),
     *      @OA\Parameter(description="EL Q.T. del paciente",@OA\Schema(type="double"), name="qt", in="query", required=false, example="440"),
     *      @OA\Parameter(description="Las conclusiones para el paciente",@OA\Schema(type="string"), name="conclusiones", in="query", required=false, example="conclusiones_example"),
     *      @OA\Parameter(description="Las recomendaciones para el paciente",@OA\Schema(type="string"), name="recomendaciones", in="query", required=false, example="recomendaciones_example"),
     *      @OA\Parameter(description="El medico evaluador del paciente",@OA\Schema(type="string"), name="medico_evaluador", in="query", required=false, example="medico_evaluador_example"),
     *      @OA\Parameter(description="La colegiatura del paciente",@OA\Schema(type="string"), name="colegiatura", in="query", required=false, example="colegiatura_example"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="ritmo", type="string", example="95 o más"),
     *                      @OA\Property(property="pr", type="double", example="0.1"),
     *                      @OA\Property(property="frecuencia", type="string", example="Entre 80 - 70"),
     *                      @OA\Property(property="qrs", type="double", example="0.07"),
     *                      @OA\Property(property="eje_electrico", type="integer", example="10"),
     *                      @OA\Property(property="qt", type="double", example="440"),
     *                      @OA\Property(property="conclusiones", type="string", example="conclusiones_example"),
     *                      @OA\Property(property="recomendaciones", type="string", example="recomendaciones_example"),
     *                      @OA\Property(property="medico_evaluador", type="string", example="medico_evaluador_example"),
     *                      @OA\Property(property="colegiatura", type="string", example="colegiatura_example"),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="El dato ekg fue creado correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene acceso")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El dato ekg no se ha creado")
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
                $datos_ekg=DatosEkg::create([
                    'ritmo' => $request->ritmo,
                    'pr' => $request->pr,
                    'frecuencia' => $request->frecuencia,
                    'qrs' => $request->qrs,
                    'eje_electrico' => $request->eje_electrico,
                    'qt' => $request->qt,
                    'conclusiones' => $request->conclusiones,
                    'recomendaciones' => $request->recomendaciones,
                    'medico_evaluador' => $request->medico_evaluador,
                    'colegiatura' => $request->colegiatura,
                ]);
                Ekg::create([
                'datos_ekg'=>$datos_ekg->id,
                ]);
            DB::commit();
            }else{
            return response()->json(["Error"=>"No tiene acceso"],400);
            }
            return response()->json(["resp" => "El dato ekg fue creado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato ekg no se ha creado" => "".$e],501);
        }
    }

    /**
     * Modifica Datos de Datos Ekg
     * @OA\Put(
     *     path = "/api/ekg/datosekg/update/{id}",
     *     summary = "Modificando Datos de DatosEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosEkg - EKG"},
     *      @OA\Parameter(in="path",name="id",required=true,@OA\Schema(type="integer")),
     *      @OA\Parameter(description="El ritmo cardiaco del paciente",@OA\Schema(type="string"), name="ritmo", in="query", required=false, example="95 o más"),
     *      @OA\Parameter(description="El P.R. del paciente",@OA\Schema(type="double"), name="pr", in="query", required=false, example="0.1"),
     *      @OA\Parameter(description="La frecuencia cardiaca del paciente",@OA\Schema(type="string"), name="frecuencia", in="query", required=false, example="Entre 80 - 70"),
     *      @OA\Parameter(description="El Q.R.S. del paciente",@OA\Schema(type="double"), name="qrs", in="query", required=false, example="0.07"),
     *      @OA\Parameter(description="El eje eléctrico del paciente",@OA\Schema(type="integer"), name="eje_electrico", in="query", required=false, example="-10"),
     *      @OA\Parameter(description="EL Q.T. del paciente",@OA\Schema(type="double"), name="qt", in="query", required=false, example="440"),
     *      @OA\Parameter(description="Las conclusiones para el paciente",@OA\Schema(type="string"), name="conclusiones", in="query", required=false, example="conclusiones_example"),
     *      @OA\Parameter(description="Las recomendaciones para el paciente",@OA\Schema(type="string"), name="recomendaciones", in="query", required=false, example="recomendaciones_example"),
     *      @OA\Parameter(description="El medico evaluador del paciente",@OA\Schema(type="string"), name="medico_evaluador", in="query", required=false, example="medico_evaluador_example"),
     *      @OA\Parameter(description="La colegiatura del paciente",@OA\Schema(type="string"), name="colegiatura", in="query", required=false, example="colegiatura_example"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                      @OA\Property(property="ritmo", type="string", example="95 o más"),
     *                      @OA\Property(property="pr", type="double", example="0.1"),
     *                      @OA\Property(property="frecuencia", type="string", example="Entre 80 - 70"),
     *                      @OA\Property(property="qrs", type="double", example="0.07"),
     *                      @OA\Property(property="eje_electrico", type="integer", example="10"),
     *                      @OA\Property(property="qt", type="double", example="440"),
     *                      @OA\Property(property="conclusiones", type="string", example="conclusiones_example"),
     *                      @OA\Property(property="recomendaciones", type="string", example="recomendaciones_example"),
     *                      @OA\Property(property="medico_evaluador", type="string", example="medico_evaluador_example"),
     *                      @OA\Property(property="colegiatura", type="string", example="colegiatura_example"),
     *                  )
     *              )
     *      ),
     *         @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Dato Ekg actualizado correctamente")
     *         )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="El dato ekg no se encuentra activo o no existe")
     *             )
     *         ),
     *         @OA\Response(response=501,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El dato ekg no se ha actualizado")
     *             )
     *         )
     * )
     */
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica=Clinica::where('id', $usuario->user_rol[0]->rol->clinica_id)->first();
            if($clinica)
            {
                $dato = DatosEkg::where('estado_registro', 'A')->find($id);
                if(!$dato){
                    return response()->json(["error" => "El dato ekg no se encuentra activo o no existe"],400);
                }
                $dato->fill([
                    'ritmo' => $request->ritmo,
                    'pr' => $request->pr,
                    'frecuencia' => $request->frecuencia,
                    'qrs' => $request->qrs,
                    'eje_electrico' => $request->eje_electrico,
                    'qt' => $request->qt,
                    'conclusiones' => $request->conclusiones,
                    'recomendaciones' => $request->recomendaciones,
                    'medico_evaluador' => $request->medico_evaluador,
                    'colegiatura' => $request->colegiatura,
                ])->save();
            }else{
                return response()->json(["Error"=>"No tiene acceso"]);
            }
            DB::commit();
            return response()->json(["resp" => "Dato Ekg actualizado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato ekg no se ha actualizado" => $e],501);
        }
    }

    /**
     * Activar
     * @OA\Put (
     *     path="/api/ekg/datosekg/activate/{id}",
     *     summary = "Activando Datos de DatosEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosEkg - EKG"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Dato Ekg activado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El dato ekg no existe"),
     *              )
     *          ),
     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El dato ekg ya está activado"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El dato ekg no se ha activado"),
     *              )
     *          ),
     * )
    */

    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $activate = DatosEkg::where('estado_registro', 'I')->find($id);
            $exists = DatosEkg::find($id);
            if(!$exists){
                return response()->json(["error"=>"El dato ekg no existe"],402);
            }
            if(!$activate){
                return response()->json(["error" => "El dato ekg ya está activado"],401);
            }
            $activate->fill([
                'estado_registro' => 'A',
            ])->save();
            DB::commit();
            return response()->json(["resp" => "Dato Ekg activado correctamente"],200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error: El dato ekg no se ha activado" => $e],501);
        }
    }

    /**
     * Delete
     * @OA\Delete (
     *     path="/api/ekg/datosekg/delete/{id}",
     *     summary = "Eliminando Datos de DatosEkg",
     *     security={{ "bearerAuth": {} }},
     *     tags={"DatosEkg - EKG"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Dato Ekg eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El dato ekg a eliminar ya está inactivado"),
     *              )
     *          ),
     *     @OA\Response(response=402,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="El dato ekg a eliminar no se encuentra"),
     *              )
     *          ),
     *     @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Error: El dato ekg no se ha eliminado"),
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
                 $registro1 = DatosEkg::where('estado_registro', 'I')->find($id);
                 if($registro1) return response()->json(["Error" => "El dato ekg a eliminar ya está inactivado"],401);
                 $registro = DatosEkg::where('estado_registro', 'A')->find($id);
                 if(!$registro) return response()->json(["Error" => "El dato ekg a eliminar no se encuentra"],402);
                 $registro->fill([
                     'estado_registro' => 'I',
                 ])->save();
             }else{
                 return response()->json(["Error"=>"No tiene acceso"]);
             }
             DB::commit();
             return response()->json(["resp" => "Dato Ekg eliminado correctamente"],200);
         } catch (Exception $e) {
             DB::rollBack();
             return response()->json(["Error: El dato ekg no se ha eliminado" => $e],501);
         }
     }
}
