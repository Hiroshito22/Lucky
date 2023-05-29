<?php

namespace App\Http\Controllers;

use App\Models\AreaMedica;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaMedicaController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $bregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            AreaMedica::create([
                "bregma_id" => $bregma->user_rol[0]->rol->bregma_id,
                "nombre" => $request->nombre,
                "icono" => $request->icono,
                "precio_referencial" => $request->precio_referencial,
                "precio_mensual" => $request->precio_mensual,
                "precio_anual" => $request->precio_anual
            ]);
            DB::commit();
            return response()->json("Area Medica creado");
        } catch (Exception $e) {
            return response()->json(["resp" => "Error " . $e]);
        }
    }

    public function update(Request $request, $Idpaquete)
    {
        DB::beginTransaction();
        try {
            $bregma = AreaMedica::find($Idpaquete);
            if ($bregma) {
                $bregma->fill(array(
                    "nombre" => $request->nombre,
                    "icono" => $request->icono,
                    "precio_referencial" => $request->precio_referencial,
                    "precio_mensual" => $request->precio_mensual,
                    "precio_anual" => $request->precio_anual
                ));
                $bregma->save();
                DB::commit();
                return response()->json(["resp" => "Area Medica actualizada"]);
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
            $bregma = AreaMedica::find($Id);
            if ($bregma) {
                $bregma->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Area Medica eliminada"]);
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
            $userbregma = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $bregma = AreaMedica::with('bregma.tipo_documento')
                ->where('bregma_id', $userbregma->user_rol[0]->rol->bregma_id)
                ->where('estado_registro', 'A')
                ->get();
            return response()->json(["data" => $bregma, "size" => count($bregma)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error" . $e]);
        }
    }
}
