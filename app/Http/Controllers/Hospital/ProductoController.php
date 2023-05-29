<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Producto;
use App\Models\ServicioHospital;
use App\Models\ServicioProducto;
use App\User;
use Illuminate\Http\Request;

class ProductoController extends Controller
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
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento',$usuario->username)->first();
        $productos = Producto::where('hospital_id',$hospital->id)->where('estado_registro', 'A')->get();
        return response()->json(["data" => $productos, "size" => count($productos)], 200);
    }
    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento',$usuario->username)->first();
        $paquete = Producto::updateOrCreate(
            [
                "nombre" => $request->nombre,
                "hospital_id" => $hospital->id
            ],
            [
                "precio" => $request->precio,
                "estado_registro" => 'A',
            ]
        );
        return response()->json(["resp" => "Perfil actualizado correctamente"]);
    }
    public function update($idProducto, Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $producto = Producto::find($idProducto);
        $producto->fill([
            "nombre" => $request->nombre,
            "precio" => $request->precio,
        ])->save();
        return response()->json(["resp" => "Perfil actualizado correctamente"]);
    }
    public function destroy($idProducto)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $producto = Producto::find($idProducto);
        $producto->fill([
            "estado_registro" => 'I',
        ])->save();

        return response()->json(["resp" => "Perfil eliminado correctamente"]);
    }
    public function getServicios($idProducto)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicio_producto = ServicioProducto::with(['servicio_hospital.servicio', 'producto'])->where('estado_registro', 'A')->where('producto_id', $idProducto)->get();
        return response()->json(["data" => $servicio_producto, "size" => count($servicio_producto)], 200);
    }
    public function getAllServicios()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento',$usuario->username)->first();
        $servicio_hospital = ServicioHospital::with(['servicio'])->where('hospital_id',$hospital->id)->where('estado',1)->where('estado_registro','A')->get();
        return response()->json(["data" => $servicio_hospital, "size" => count($servicio_hospital)], 200);
    }
}
