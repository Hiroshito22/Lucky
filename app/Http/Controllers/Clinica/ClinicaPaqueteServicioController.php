<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\ClinicaPaquete;
use App\Models\ClinicaPaqueteServicio;
use App\Models\ClinicaServicio;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicaPaqueteServicioController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/paquetes/asignar/services/{paquete_id}",
     *     summary="Asignar servicios a un paquete de una clínica",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Paquete - Servicio"},
     *     @OA\Parameter(name="paquete_id", in="path", description="ID del paquete de la clínica", required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(required=true, description="Los servicios que se asignarán al paquete",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="servicios", type="array", description="Lista de ID de los servicios",
     *                 @OA\Items(type="integer")),
     *         )
     *     ),
     *     @OA\Response(response="200", description="success",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="resp", type="string", description="Mensaje de respuesta", example="Los servicios se han asignado correctamente al paquete"),
     *         )
     *     ),
     *     @OA\Response(response="400", description="invalid",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="string", description="Mensaje de error", example="Los servicios no existen")
     *         )
     *     ),
     *     @OA\Response(response="401", description="invalid",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="string", description="Mensaje de error", example="El paquete no existe")
     *         )
     *     ),
     *     @OA\Response(response="500", description="invalid",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="resp", type="string", description="Mensaje de respuesta", example="Error al asignar servicios al Paquete, intente otra vez!"),
     *         )
     *     ),
     * )
     */
    public function asignarServicios(Request $request, $paquete_id)
    {
        DB::beginTransaction();
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();

            $paquete = ClinicaPaquete::find($paquete_id);
            if (!$paquete) {
                return response()->json(['error' => 'El paquete no existe'], 401);
            }

            $servicio_id = $request->input('servicios', []);

            $existen_servicios = ClinicaServicio::whereIn('id', $servicio_id)->exists();
            if (!$existen_servicios) {
                return response()->json(['error' => 'Los servicios no existen'], 400);
            }

            $syncData = [];
            foreach ($servicio_id as $id) {
                $syncData[$id] = ['clinica_paquete_id' => $paquete_id, 'clinica_id' => $user->user_rol[0]->rol->clinica_id,];
            }
            //$paquete->servicios()->sync($syncData);
            $paquete->servicios()->syncWithoutDetaching($syncData);

            DB::commit();
            return response()->json(['resp' => "Los servicios se han asignado correctamente al paquete"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => "Error al asignar servicios al Paquete, intente otra vez!" . $e], 500);
        }
    }

    /**
     * Mostrar Datos de Clínica Paquetes
     * @OA\Get (
     *     path="/api/paquetes/servicios/show",
     *     summary="Muestra datos de Clínica Paquete Servicio",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Clínica - Paquete - Servicio"},
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="clinica_paquete_id", type="number", example=1),
     *                      @OA\Property(property="clinica_servicio_id", type="number", example=1),
     *                      @OA\Property(property="clinica_id", type="number", example=1),
     *                      @OA\Property(property="estado_registro", type="char", example="A"),
     *
     *                      @OA\Property(type="array", property="clinica_paquete",
     *                          @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="nombre",type="string",example="Paquete 1"),
     *                             @OA\Property(property="clinica_id", type="number", example=1),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *                         )
     *                      ),
     *                      @OA\Property(type="array", property="clinica_servicio",
     *                          @OA\Items(type="object",
     *                             @OA\Property(property="id",type="integer",example="1"),
     *                             @OA\Property(property="servicio_id", type="number", example=1),
     *                             @OA\Property(property="clinica_id", type="number", example=1),
     *                             @OA\Property(property="ficha_medico_ocupacional_id", type="number", example=1),
     *                             @OA\Property(property="estado_registro",type="char",example="A"),
     *
     *                             @OA\Property(type="array", property="clinica_servicio",
     *                                 @OA\Items(type="object",
     *                                     @OA\Property(property="id",type="integer",example="1"),
     *                                     @OA\Property(property="nombre",type="string",example="Triaje"),
     *                                     @OA\Property(property="precio",type="float",example="10"),
     *                                     @OA\Property(property="estado_registro",type="char",example="A"),
     *                                 )
     *                             ),
     *                         )
     *                      ),
     *                  )
     *              ),
     *              @OA\Property(type="count", property="size", example="1")
     *          )
     *      ),
     *      @OA\Response(response=404, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Clínica Paquete no se encontro o no existe"),
     *         )
     *      ),
     *      @OA\Response(response=500, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Error al llamar Clínica Paquete, intente otra vez!"),
     *         ),
     *      )
     * )
     */
    public function show()
    {
        try {
            $usuario = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $usuario->user_rol[0]->rol->clinica_id;
            $paqueteServicio = ClinicaPaqueteServicio::with('clinica_paquete', 'clinica_servicio.servicio')->where('estado_registro', 'A')->where('clinica_id', $clinica_id)->get();

            if (!$paqueteServicio) {
                return response()->json(['resp' => 'Clinica Paquete Servicio no se encontro o no existe'], 404);
            }
            return response()->json(["data" => $paqueteServicio, "size" => count($paqueteServicio)], 200);
        } catch (Exception $e) {
            return response()->json(["Error"=> "".$e],500);
        }
    }
}
