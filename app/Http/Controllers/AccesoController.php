<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acceso;
use App\User;
use Illuminate\Support\Facades\DB;

class AccesoController extends Controller
{
    public function validar_acceso($tipo_acceso,$url){
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach($admin_hospital->roles as $roles){
            foreach($roles->accesos as $accesos){
                if($accesos['tipo_acceso']==$tipo_acceso && $accesos["url"]==$url){
                    return $valido=true;
                }
            }
        }
        return $valido;
    }
    public function acceso_hospital()
    {
        if ($this->validar_acceso(2, "/rolHospital") == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $acceso = Acceso::where('tipo_acceso', 2)->get();
        return response()->json(["data" => $acceso, "size" => count($acceso)], 200, [], JSON_NUMERIC_CHECK);
    }
    public function acceso_superadmin()
    {
        $acceso = Acceso::where('tipo_acceso', 1)->get();
        return response()->json(["data" => $acceso, "size" => count($acceso)]);
    }
    public function getaccesosbylogin()
    {
        $usuario = User::with('user_rol.rol')->find(auth()->user()->id);
        $accesos = Acceso::where('tipo_acceso',$usuario->user_rol[0]->rol->tipo_acceso)->where('parent_id',null)->get();
        return response()->json(["data"=>$accesos,"size"=>count($accesos)]);
    }
}
