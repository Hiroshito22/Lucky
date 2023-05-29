<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Hospital;
use App\Models\Cargo;

class CargoController extends Controller
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
    
    public function get(){
        if($this->validar_acceso(2,"/cargosHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $cargo = Cargo::where('hospital_id',$hospital->id)->where('estado_registro','A')->get();
        }
        return response()->json(["data"=>$cargo,"size"=>count($cargo)]);
        
    }
    public function create(Request $request){
        if($this->validar_acceso(2,"/cargosHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $cargo = Cargo::updateOrCreate(
                [
                    "nombre"=>$request->nombre,
                    "hospital_id"=>$hospital->id,
                ],
                [
                    "descripcion"=>$request->descripcion,
                    "estado_registro"=>"A"
                ]
            );
        }
        return response()->json(["resp"=>"creado correctamente"]);
    }
    public function update(Request $request,$idCargo){
        if($this->validar_acceso(2,"/cargosHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $cargo = Cargo::find($idCargo);
        if($hospital){
            if($cargo->hospital_id==$hospital->id){
                $cargo->fill([
                    "nombre"=>$request->nombre,
                    "descripcion"=>$request->descripcion,
                ])->save();
            }
        }
        return response()->json(["resp"=>"editado correctamente"]);
    }
    public function delete($idCargo){
        if($this->validar_acceso(2,"/cargosHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $cargo = Cargo::find($idCargo);
        if($hospital){
            if($cargo->hospital_id==$hospital->id){
                $cargo->fill([
                    "estado_registro"=>"I"
                ])->save();
            }
        }
        return response()->json(["resp"=>"Eliminado correctamente"]);
    }
}
