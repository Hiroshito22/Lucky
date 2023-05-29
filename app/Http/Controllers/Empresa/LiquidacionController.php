<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Empresa;
use App\Models\Liquidacion;
class LiquidacionController extends Controller
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
        if ($this->admin(3,'/empresa/liquidacion') == false) {
                return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $empresa = Empresa::where("ruc",$usuario->persona->numero_documento)->first();
        if($empresa){
            $empresa = $empresa;
        }
        $liquidacion = Liquidacion::with('liquidacion_detalle.atencion.trabajador.persona.tipo_documento','liquidacion_detalle.atencion.paquete','hospital')->where('empresa_id',$empresa->id)->where('estado_registro','A')->get();
        return response()->json(["data"=>$liquidacion,"size"=>count($liquidacion)]);
    }
}
