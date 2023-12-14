<?php

namespace App\Http\Controllers;

use App\Models\Destinatario;
use App\Models\Proveedor;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorDestinatarioController extends Controller
{
    public function create_proveedor(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $proveedor = Proveedor::create([
                "proveedor" => $request->proveedor,
            ]);
            DB::commit();
            return response()->json(["resp" => "Proveedor creado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function update_proveedor(Request $request,$id_proveedor)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $proveedor = Proveedor::find($id_proveedor)->first();
            $proveedor->fill([
                "proveedor" => $request->proveedor,
            ])
            ->save();
            DB::commit();
            return response()->json(["resp" => "Proveedor actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
    public function delete_proveedor($id_proveedor){
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $proveedor = Proveedor::find($id_proveedor);
            $proveedor->delete();
        DB::commit();
        return response()->json(["resp" => "Proveedor eliminada correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function get_proveedor()
    {
        try {
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();

            $trabajador = Proveedor::get();

            return response()->json(["data" => $trabajador, "size" => (count($trabajador))], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar a los proveedores  " . $e], 400);
        }
    }

    //------------------------------------------------------------------------

    public function create_destinatario(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $destinatario = Destinatario::create([
                "destinatario" => $request->destinatario,
            ]);
            DB::commit();
            return response()->json(["resp" => "Destinatario creado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function update_destinatario(Request $request,$id_destinatario)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $destinatario = Destinatario::find($id_destinatario)->first();
            $destinatario->fill([
                "destinatario" => $request->destinatario,
            ])
            ->save();
            DB::commit();
            return response()->json(["resp" => "Destinatario actualizado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
    public function delete_destinatario($id_destinatario){
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $destinatario = Destinatario::find($id_destinatario);
            $destinatario->delete();
        DB::commit();
        return response()->json(["resp" => "Destinatario eliminada correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function get_destinatario()
    {
        try {
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();

            $trabajador = Destinatario::get();

            return response()->json(["data" => $trabajador, "size" => (count($trabajador))], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar a los almacenes  " . $e], 400);
        }
    }
}
