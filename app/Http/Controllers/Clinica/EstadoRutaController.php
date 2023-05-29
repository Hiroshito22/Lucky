<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\EstadoRuta;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadoRutaController extends Controller
{

    /**
     * Crea un Estado de Hoja de Ruta
     * @OA\POST (
     *     path="/api/clinica/hoja_ruta/estado/create",
     *     summary="Crea un estado de hoja de ruta con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Estado"},
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required= true
     *      ),           
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Estado de la Hoja de Ruta creado"),
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
            if ($userclinica) {
                EstadoRuta::create([
                    "nombre" => $request->nombre,
                ]);
                DB::commit();
                return response()->json(["resp" => "Estado de Ruta creado"]);
            } else {
                return response()->json(["resp" => "Usuario Clinica no logeado"]);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Actualiza un Estado Hoja de Ruta
     * @OA\PUT (
     *     path="/api/clinica/hoja_ruta/estado/update/{id}",
     *     summary="Actualiza un Estado de hoja de ruta con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Estado"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Parameter(description="Nombre",
     *          @OA\Schema(type="string"), name="nombre", in="query", required= true
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Estado de la Hoja de Ruta actualizado"),
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
            $userclinica = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            if ($userclinica) {
                $estado_ruta = EstadoRuta::find($Idruta);
                if ($estado_ruta) {
                    $estado_ruta->fill(array(
                        "nombre" => $request->nombre,
                    ));
                    $estado_ruta->save();
                    DB::commit();
                    return response()->json(["resp" => "Estado de Ruta actualizado"]);
                } else {
                    return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
                }
            } else {
                return response()->json(["resp" => "Usuario Clinica no logeado"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }


    /**
     * Elimina un Estado de Hoja de Ruta
     * @OA\DELETE (
     *     path="/api/clinica/hoja_ruta/estado/delete/{id}",
     *     summary="Elimina un estado de hoja de ruta con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Estado"},
     *      @OA\Parameter(description="Id",          
     *          @OA\Schema(type="number"),name="id",in="path",required= true,example=1            
     *      ), 
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Estado de la Hoja de Ruta eliminado"),
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
            $estado_ruta = EstadoRuta::find($Id);
            if ($estado_ruta) {
                $estado_ruta->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Estado de Ruta eliminada"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    /**
     * Mostrar los estados de hojas de rutas
     * @OA\GET (
     *     path="/api/clinica/hoja_ruta/estado/show",
     *     summary="Muestra los estados hojas de rutas con sesión iniciada",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Hoja de Ruta Estado"},
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="nombre"),
     *              @OA\Property(property="estado_registro", type="string", example="A"),
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
            $userclinica = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            if ($userclinica) {
                $estado_ruta = EstadoRuta::where('estado_registro', 'A')->get();
                return response()->json(["data" => $estado_ruta, "size" => count($estado_ruta)], 200);
            } else {
                return response()->json(["resp" => "No inicio sesion"]);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
