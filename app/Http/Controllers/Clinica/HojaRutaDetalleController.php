<?php

namespace App\Http\Controllers\Clinica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HojaRutaDetalle;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;

class HojaRutaDetalleController extends Controller
{

    /**
     * Crea una Hoja de Ruta Detalle
     * @OA\POST (
     *     path="/api/clinica/hoja_ruta/detalle/create",
     *     summary="Crea una hoja de ruta con detalle con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Detalle"},
     *      @OA\Parameter(description="Id de la Hoja de Ruta",
     *          @OA\Schema(type="string"), name="hoja_ruta_id", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Id de la Clinica Servicio",
     *          @OA\Schema(type="string"),name="clinica_servicio_id",in="query",required= false
     *      ), 
     *      @OA\Parameter(description="Id del estado de Ruta",
     *          @OA\Schema(type="string"),name="estado_ruta_id",in="query",required= false
     *      ),      
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detalle de la Hoja de Ruta creado"),
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
            $userclinica = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            if($userclinica){
                HojaRutaDetalle::create([
                    "hoja_ruta_id" => $request->hoja_ruta_id,
                    "clinica_servicio_id" => $request->clinica_servicio_id,
                    "estado_ruta_id" => $request->estado_ruta_id,
                ]);
                DB::commit();
                return response()->json(["resp" => "Hoja de Ruta Detalle creado"]);
            }else{
                return response()->json(["resp" => "No inicio sesión"]);
            }            
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Actualiza una Hoja de Ruta Detalle
     * @OA\PUT (
     *     path="/api/clinica/hoja_ruta/detalle/update/{id}",
     *     summary="Actualiza una hoja de ruta con detalle con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Detalle"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Parameter(description="Id de la Hoja de Ruta",
     *          @OA\Schema(type="string"), name="hoja_ruta_id", in="query", required= true
     *      ),
     *      @OA\Parameter(description="Id de la Clinica Servicio",
     *          @OA\Schema(type="string"),name="clinica_servicio_id",in="query",required= false
     *      ), 
     *      @OA\Parameter(description="Id del estado de Ruta",
     *          @OA\Schema(type="string"),name="estado_ruta_id",in="query",required= false
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detalle de la Hoja de Ruta actualizado"),
     *          )
     *      ),     
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al actualizar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $Idruta)
    {
        DB::beginTransaction();
        try {
            $hrd = HojaRutaDetalle::find($Idruta);
            if ($hrd) {
                $hrd->fill(array(
                    "hoja_ruta_id" => $request->hoja_ruta_id,
                    "clinica_servicio_id" => $request->clinica_servicio_id,
                    "estado_ruta_id" => $request->estado_ruta_id,
                ));
                $hrd->save();
                DB::commit();
                return response()->json(["resp" => "Hoja de Ruta Detalle actualizado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }


    /**
     * Elimina una Hoja de Ruta Detalle
     * @OA\DELETE (
     *     path="/api/clinica/hoja_ruta/detalle/delete/{id}",
     *     summary="Elimina una hoja de ruta con detalle con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Detalle"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Detalle de la Hoja de Ruta eliminado"),
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
            $hrd = HojaRutaDetalle::find($Id);
            if ($hrd) {
                $hrd->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Hoja de Ruta Detalle eliminada"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Mostrar las hojas de ruta con detalle
     * @OA\GET (
     *     path="/api/clinica/hoja_ruta/detalle/show",
     *     summary="Muestra las hojas de rutas con detalles con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Detalle"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="hoja_ruta_id", type="number", example=1),
     *              @OA\Property(property="clinica_servicio_id", type="number", example=1),
     *              @OA\Property(property="estado_ruta_id", type="number", example=1),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
     *              @OA\Property(type="array",property="hoja_ruta",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                      @OA\Property(property="distrito_id", type="number", example=1),
     *                      @OA\Property(property="numero_documento", type="string", example="Documento Nacional de Identidad"),                      
     *                  )
     *              ),
     *              @OA\Property(type="array",property="clinica_servicio",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="servicio_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="nombre"),
     *                      @OA\Property(property="icono", type="string", example="icono"),
     *                      @OA\Property(property="parent_id", type="number", example=1),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                      @OA\Property(type="array",property="clinica",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="number", example=1),
     *                              @OA\Property(property="bregma_id", type="number", example=1),
     *                              @OA\Property(property="tipo_documento_id", type="number", example=1),
     *                              @OA\Property(property="distrito_id", type="number", example=1),
     *                              @OA\Property(property="razon_social", type="string", example="razon_social"),
     *                              @OA\Property(property="numero_documento", type="string", example="98765432"),
     *                              @OA\Property(property="responsable", type="string", example="reaponsable"),
     *                              @OA\Property(property="nombre_comercial", type="sting", example="nombre_comercial"),
     *                              @OA\Property(property="latitud", type="sting", example="latitud"),
     *                              @OA\Property(property="longitud", type="sting", example="longitud"),
     *                              @OA\Property(property="direccion", type="sting", example="direccion"),
     *                              @OA\Property(property="logo", type="sting", example="logo"),
     *                              @OA\Property(property="estado_registro", type="string", example="A"),
     *                              @OA\Property(property="hospital_id", type="number", example=1),
     *                              @OA\Property(type="array",property="tipo_documento",
     *                                  @OA\Items(type="object",
     *                                      @OA\Property(property="id", type="number", example=1),
     *                                      @OA\Property(property="nombre", type="string", example="DNI"),
     *                                      @OA\Property(property="codigo", type="string", example="codigo"),
     *                                      @OA\Property(property="descripcion", type="string", example="Documento Nacional de Identidad"),
     *                                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                                  )
     *                              ),
     *                          )
     *                      ),             
     *                  )
     *              ),
     *              @OA\Property(type="array",property="estado_ruta",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="nombre", type="string", example="nombre"),
     *                      @OA\Property(property="estado_registro", type="string", example="A"),
     *                  )
     *              ),
     *          )
     *      ),     
     *      @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Error al mostrar, intentelo de nuevo"),
     *          )
     *      ),
     * )
     */
    public function show()
    {
        try {
            $hrd = HojaRutaDetalle::with('hoja_ruta','clinica_servicio.clinica.tipo_documento','estado_ruta')
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $hrd, "size" => count($hrd)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
