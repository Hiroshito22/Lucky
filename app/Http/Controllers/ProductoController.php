<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Producto;
use App\Models\Trabajador;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();
            $producto = Producto::create([
                "descripcion" => $request->descripcion,
                "empresa_id" => $request->empresa_id,
                "marca_id" => $request->marca_id,
                "foto" => $request->foto,
                "cantidad" => $request->cantidad
            ]);
            DB::commit();
            return response()->json(["resp" => "Producto creado correctamente"], 200);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
}
