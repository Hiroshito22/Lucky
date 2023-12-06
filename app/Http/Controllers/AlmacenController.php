<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $almacen = Almacen::create([
                "descripcion" => $request->descripcion,
                "producto_id" => $request->producto_id,
                "empresa_id" => $request->empresa_id
            ]);
            DB::commit();
            return response()->json(["resp" => "Almacen creado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $almacen = Almacen::fill([
                "descripcion" => $request->descripcion,
                "producto_id" => $request->producto_id,
                "empresa_id" => $request->empresa_id
            ])
            ->save();
            DB::commit();
            return response()->json(["resp" => "Almacen actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
}
