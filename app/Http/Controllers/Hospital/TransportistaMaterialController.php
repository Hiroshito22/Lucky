<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\TransportistaMaterial;
use App\User;
use Illuminate\Http\Request;

class TransportistaMaterialController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2) {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    public function getMateriales($idTransportista)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento', $usuario->username)->first();
        $materiales = TransportistaMaterial::where('transportista_id',$idTransportista)->with('transportista', 'material')->where('estado_registro', 'A')->get();

        return response()->json(["data" => $materiales, "size" => count($materiales)]);
    }


}
