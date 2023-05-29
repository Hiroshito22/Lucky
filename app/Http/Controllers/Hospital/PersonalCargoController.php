<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Hospital;
use App\Models\Personal;
use App\Models\Persona;
use App\Models\PersonalCargo;
class PersonalCargoController extends Controller
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
    public function getPersonal($idPersonal){
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $personal = PersonalCargo::with('personal.persona.tipo_documento','personal.user.roles','cargo')->where('hospital_id',$hospital->id)->where('estado_registro','A')->where('personal_id',$idPersonal)->get();
        }
        return response()->json(["data"=>$personal,"size"=>count($personal)]);
        
    }
    public function delete($idPersonalCargo){
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $personal_cargo = PersonalCargo::find($idPersonalCargo);
        if($hospital){
            $personal_cargo->estado_registro = "I";
            $personal_cargo->save();
        }
        return response()->json(["resp"=>"eliminado correctamente"]);
        
    }
    public function update(Request $request,$idPersonalCargo){
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $personal = Personal::find($request->personal_id);
        $personal_cargo = PersonalCargo::find($idPersonalCargo);
        $validar_personales_cargos = PersonalCargo::where('personal_id',$request->personal_id)
        ->where('hospital_id',$personal_cargo->hospital_id)
        ->where('cargo_id','!=',$personal_cargo->cargo_id)
        ->where('estado_registro',"A")
        ->get();
        
        foreach($validar_personales_cargos as $validar){
            if($validar['cargo_id']==$request->cargo_id){
                return response()->json(["resp"=>"El cargo ya existe elimine o edite el cargo"],500);
            }
        }
        
        if($hospital){
            if($personal_cargo->hospital_id == $hospital->id){
                $personal_cargo->fill([
                    "cargo_id"=>$request->cargo_id,
                ])->save();
                if ($request->hasFile('firma')) {
                    $path = $request->file('firma')->storeAs('public/firmas', $hospital->id . '-' . $request->personal_id. '-' . $request->cargo_id . '.' . $request->firma->extension());
                    $image = $hospital->id . '-' . $request->personal_id. '-' . $request->cargo_id. '.' . $request->firma->extension();
                    $personal_cargo->firma = $image;
                    $personal_cargo->save();
                } else {
                    //$image = null;
                }
                
            }
        }
        return response()->json(["resp"=>"asignado correctamente"]);
    }
}
