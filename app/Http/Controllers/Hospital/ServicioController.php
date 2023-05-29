<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Servicio;
use App\Models\ServicioHospital;
use App\Models\ServicioProducto;
use App\User;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;

class ServicioController extends Controller
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
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();
        $servicios = ServicioHospital::with(['servicio'])->where('hospital_id', $hospital->id)->get();
        return response()->json(["data" => $servicios, "size" => count($servicios)], 200);
    }

    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicio = Servicio::updateOrCreate(
            [
                "nombre" => $request->nombre,

            ],
            [
                "precio" => $request->precio,
                "estado_registro" => 'A',
            ]
        );
        return response()->json(["resp" => "Servicio creado correctamente"]);
    }

    public function update($idServicio, Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicio = ServicioHospital::find($idServicio);
        $servicio->fill([
            "precio" => $request->precio,
        ])->save();
        return response()->json(["resp" => "Servicio actualizado correctamente"]);
    }

    public function destroy($idServicio)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicio = Servicio::find($idServicio);
        $servicio->fill([
            "estado_registro" => 'I',
        ])->save();

        return response()->json(["resp" => "Servicio eliminado correctamente"]);
    }

    public function changeEstado($idServicio)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicio_hospital = ServicioHospital::find($idServicio);
        if ($servicio_hospital->estado === "1") {
            $servicio_hospital->estado = '0';
            $servicio_producto = ServicioProducto::where('servicio_hospital_id', $servicio_hospital->id)->first();
            if ($servicio_producto) {
                $servicio_producto->estado_registro = 'I';
                $servicio_producto->save();
            }
        } else {
            $servicio_hospital->estado = '1';
        }
        $servicio_hospital->save();
        return response()->json(["resp" => "Servicio editado correctamente"]);
    }

    public function changeEstadoDelivery($idServicio)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicio_hospital = ServicioHospital::find($idServicio);
        if ($servicio_hospital->estado_delivery === "1") {
            $servicio_hospital->estado_delivery = '0';
        } else {
            $servicio_hospital->estado_delivery = '1';
        }
        $servicio_hospital->save();
        return response()->json(["resp" => "Servicio editado correctamente"]);
    }

    public function subirIcon($idServicio, Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $servicio = Servicio::find($idServicio);
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->storeAs('public/servicio/icon', $servicio->id . '-' . $servicio->nombre  . '.' . $request->icon->extension());
            $image = $servicio->id . '-' . $servicio->nombre . '.' . $request->icon->extension();
            $servicio->icon = $image;
            $servicio->save();
        }
        return response()->json(["resp" => "Servicio actualizado correctamente"]);
    }
}
