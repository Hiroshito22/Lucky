<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\ProductoPaquete;
use App\User;
use Illuminate\Http\Request;

class ProductoPaqueteController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == "/paquetes") {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $producto_paquete = ProductoPaquete::updateOrCreate([
            'producto_id' => $request->producto_id,
            'paquete_id' => $request->paquete_id,

        ], [
            'estado_registro' => 'A'
        ]);
        return response()->json(["resp" => "Producto asignado Correctamente"]);
    }

    public function destroy($idProductoPaquete)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $producto_paquete = ProductoPaquete::find($idProductoPaquete);
        $producto_paquete->fill([
            'estado_registro' => 'I'
        ])->save();
        return response()->json(["resp" => "Producto eliminado Correctamente"]);
    }
}
