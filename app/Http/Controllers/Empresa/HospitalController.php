<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function admin($tipo_acceso,$url)
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == $tipo_acceso && $accesos['url'] == $url) {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    public function get(){
        if ($this->admin(3,'/atenciones') == false) {
                return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $empresa = Empresa::where("ruc",$usuario->persona->numero_documento)->first();
        if($empresa){
            $empresa = $empresa;
        }
        $hospitales = Hospital::with()->where('empresa_id',$empresa->id)->where('estado_registro','A')->get();
        return response()->json(["data"=>$liquidacion,"size"=>count($liquidacion)]);
    }
}
