<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\TipoVehiculo;
use App\Models\Vehiculo;
use App\User;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == "/material") {
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
        $vehiculos = Vehiculo::with('tipo_vehiculo')->where('hospital_id',$hospital->id)->where('estado_registro','A')->get();
        return response()->json(["data" => $vehiculos, "size" => count($vehiculos)]);
    }
    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();
        $vehiculo = Vehiculo::updateOrCreate(
            [
                'placa' => $request->placa,
                'hospital_id' => $hospital->id,
            ],
            [
                'tipo_vehiculo_id'=>$request->tipo_vehiculo_id,
                'particular' => $request->particular,
                'estado_registro' => 'A'
            ]
        );
        return response()->json(["resp" => "Vehiculo creado correctamente"]);
    }

    public function update(Request $request, $idVehiculo)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $vehiculo = Vehiculo::find($idVehiculo);
        $vehiculo->fill(
            [
                'placa' => $request->placa,
                'tipo_vehiculo_id'=>$request->tipo_vehiculo_id,
                'particular' => $request->particular,
                'estado_regisro' => 'A'
            ]
        )->save();
        return response()->json(["resp" => "Vehiculo eliminado correctamente"]);
    }

    public function delete($idVehiculo)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $vehiculo = Vehiculo::find($idVehiculo);
        $vehiculo->fill(
            [
                'estado_regisro' => 'I'
            ]
        )->save();
        return response()->json(["resp" => "Vehiculo eliminado correctamente"]);
    }

    public function getTipoVehiculo()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $tipo_vehiculos = TipoVehiculo::where('estado_registro','A')->get();
        return response()->json(["data"=>$tipo_vehiculos,"size"=>count($tipo_vehiculos)]);
    }
}
