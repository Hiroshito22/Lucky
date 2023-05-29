<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\BregmaPaqueteCapacitacion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BregmaPaqueteCapacitacionController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            BregmaPaqueteCapacitacion::create([
                "bregma_paquete_id" => $request->bregma_paquete_id,
                "capacitacion_id" => $request->capacitacion_id,
            ]);

            DB::commit();
            return response()->json(["resp" => "Bregma Paquete Capacitación creada correctamente"], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al crear Bregma Paquete Capacitación" . $e], 400);
        }
    }

    public function update(Request $request, $idPaquete)
    {
        DB::beginTransaction();
        try {
            $paquete = BregmaPaqueteCapacitacion::find($idPaquete);

            if(!$paquete){
                return response()->json(["resp" => "Bregma Paquete Capacitación no encontrado, o no existe"], 400);
            }else{
                $paquete->fill([
                    "bregma_paquete_id" => $request->bregma_paquete_id,
                    "capacitacion_id" => $request->capacitacion_id,
                ])->save();
            }

            DB::commit();
            return response()->json(["resp" => "Bregma Paquete Capacitación actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al actualizar Bregma Paquete Capacitación" . $e], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $paqute = BregmaPaqueteCapacitacion::find($id);

            if(!$paqute){
                return response()->json(["resp" => "Bregma Paquete Capacitación a eliminar no encontrado."], 400);
            }
            $paqute->fill([
                "estado_registro" => "I",
            ])->save();

            DB::commit();
            return response()->json(["resp" => "Bregma Paquete Capacitación eliminado correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["resp" => "error", "error" => "Error al eliminar Bregma Paquete Capacitación" . $e], 500);
        }
    }

    public function show()
    {
        try {
            $paquete = BregmaPaqueteCapacitacion::with('bregma_paquete.bregma', 'capacitacion.bregma')->where('estado_registro', 'A')->get();

            if (!$paquete) {
                return response()->json(['resp' => 'Bregma Paquete Capacitacion no se encontro o no existe'], 401);
            }
            return response()->json(["data" => $paquete, "size" => count($paquete)], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar los Bregma Paquete Capacitación" . $e], 405);
        }
    }

}
