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

    public function update(Request $request,$id_producto){
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $producto = Producto::where('id', $id_producto)->first();
            $producto->fill([
                "descripcion" => $request->descripcion,
                "empresa_id" => $request->empresa_id,
                "marca_id" => $request->marca_id,
                "foto" => $request->foto,
                "cantidad" => $request->cantidad
            ])
            ->save();
        DB::commit();
        return response()->json(["resp" => "Producto actualizado correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function delete($id_producto){
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $persona = Producto::find($id_producto);
            $persona->fill([
                "estado_registro" => "I",
            ])->save();
        DB::commit();
        return response()->json(["resp" => "Producto eliminada correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function get()
    {
        try {
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();

            $trabajador = Producto::where('estado_registro', 'A')->get();

            return response()->json(["data" => $trabajador, "size" => (count($trabajador))], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar a los productos  " . $e], 400);
        }
    }
}
