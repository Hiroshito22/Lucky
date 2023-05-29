<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\ServicioProducto;
use App\User;
use Illuminate\Http\Request;

class ServicioProductoController extends Controller
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

    public function index()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $producto_paquete = ServicioProducto::where('estado_registro', 'A')->get();
        return response()->json(["data" => $producto_paquete, "size" => count($producto_paquete)], 200);
    }

    public function create(Request $request)
    {

        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $producto_paquete = ServicioProducto::updateOrCreate(
            [
                'producto_id' => $request->producto_id,
                'servicio_hospital_id' => $request->servicio_id
            ],
            [
                'estado_registro' => 'A',
            ]
        );
        return response()->json(["resp" => "Servicio asignado correctamente"]);
    }

    public function destroy($idProductoServicio)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicioProducto = ServicioProducto::find($idProductoServicio);
        $servicioProducto->fill(
            [
                'estado_registro' => 'I'
            ]
        )->save();
        return response()->json(["resp" => "Servicio eliminado correctamente"]);
    }
}
