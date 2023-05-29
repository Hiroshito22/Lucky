<?php

namespace App\Http\Controllers;

use App\Models\TeamBig;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamBigController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $teambig = TeamBig::create([
                "nombre" => $request->nombre,
                "medida" => $request->medida,
                "contenido" => $request->contenido,
                "caducidad" => $request->caducidad,
            ]);
            DB::commit();
            return response()->json(["resp" => "creado satisfactoriamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }


    public function update(Request $request, $Id)
    {
        DB::beginTransaction();
        try {
            $teambig = TeamBig::find($Id);
            if ($teambig) {
                $teambig->fill(array(
                    "nombre" => $request->nombre,
                    "medida" => $request->medida,
                    "contenido" => $request->contenido,
                    "caducidad" => $request->caducidad,
                ));
                $teambig->save();
                DB::commit();
                return response()->json(["resp" => "Producto actualizado"]);
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
            $soporte = TeamBig::find($Id);
            if ($soporte) {
                $soporte->fill([
                    "estado_registro" => "I",
                ])->save();
                DB::commit();
                return response()->json(["Resp" => "Soporte eliminado"]);
            } else {
                return response()->json(["resp" => "El ID no existe en la Base de Datos"]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e]);
        }
    }

    public function destroy($Id)
    {
        try {
            DB::beginTransaction();
            $soporte = TeamBig::find($Id);
            if ($soporte) {
                $soporte->delete();
                DB::commit();
                return response()->json(["Resp" => "Soporte eliminado de la base de datos"]);
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
            $soporte = TeamBig::where('estado_registro', 'A')
                ->get();
            return response()->json(["Productos" => $soporte, "Total de Productos" => count($soporte)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "error", "error" => $e]);
        }
    }
}
