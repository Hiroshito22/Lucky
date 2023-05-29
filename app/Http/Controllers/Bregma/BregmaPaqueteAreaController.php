<?php

namespace App\Http\Controllers\Bregma;

use App\Http\Controllers\Controller;
use App\Models\BregmaPaqueteArea;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BregmaPaqueteAreaController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            BregmaPaqueteArea::create([
                "bregma_paquete_id" => $request->bregma_paquete_id,
                "area_medica_id" => $request->area_medica_id
            ]);
            DB::commit();
            return response()->json("Paquete de bregma area creado");
        } catch (Exception $e) {
            return response()->json(["resp" => "Error " . $e]);
        }
    }

    public function update(Request $request, $Idpaquete)
    {
        DB::beginTransaction();
        try {
            $bregma = BregmaPaqueteArea::find($Idpaquete);
            if ($bregma) {
                $bregma->fill(array(
                    "bregma_paquete_id" => $request->bregma_paquete_id,
                    "area_medica_id" => $request->area_medica_id
                ));
                $bregma->save();
                DB::commit();
                return response()->json(["resp" => "Paquete de bregma area actualizada"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error" . $e]);
        }
    }

    public function delete($Id)
    {
        try {
            DB::beginTransaction();
            $bregma = BregmaPaqueteArea::find($Id);
            if ($bregma) {
                $bregma->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Paquete eliminado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    public function show()
    {
        try {
            $bregma = BregmaPaqueteArea::with(
                'bregma_paquete.bregma.tipo_documento',
                'area_medica.bregma.tipo_documento')
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $bregma, "size" => count($bregma)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error" . $e]);
        }
    }
}
