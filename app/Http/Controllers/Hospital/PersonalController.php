<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Hospital;
use App\Models\Personal;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\UserRol;
use App\Models\PersonalCargo;
class PersonalController extends Controller
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
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $personal = Personal::with('persona.tipo_documento','user.roles')->where('hospital_id',$hospital->id)->where('estado_registro','A')->get();
        }
        return response()->json(["data"=>$personal,"size"=>count($personal)]);
        
    }
    public function create(Request $request){
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $personal = Personal::where('user_id',auth()->user()->id)->first();
        if($hospital || $personal){
            $persona = Persona::firstOrCreate(
                [
                    "tipo_documento_id"=>$request->tipo_documento_id,
                    "numero_documento"=>$request->numero_documento,
                ],
                [
                    "nombres"=>$request->nombres,
                    "apellido_paterno"=>$request->apellido_paterno,
                    "apellido_materno"=>$request->apellido_materno,
                    "telefono"=>$request->telefono,
                    "email"=>$request->email,
                    "grado_instruccion_id"=>$request->grado_instruccion_id,
                    
                ]
            );
            $user = User::updateOrCreate(
                [
                    "username"=>$persona->numero_documento,
                    "persona_id"=>$persona->id,
                ],
                [
                    "password"=>$persona->numero_documento,
                ]
            );
            $rol = Rol::find($request->rol_id);
            
                $user_rol = UserRol::updateOrCreate(
                    [
                        "user_id"=>$user->id,
                        "rol_id"=>$rol->id,
                        
                    ],
                    [
                        
                        "estado_registro"=>"A",
                    ]
                );
            
            
            if($hospital){
                $personal = Personal::updateOrCreate(
                    [
                        "persona_id"=>$persona->id,
                        "hospital_id"=>$hospital->id,
                        "user_id"=>$user->id,
                    ],
                    [
                        
                        "estado_registro"=>"A"
                    ]
                );
            }
            if($personal){
                $personal = Personal::updateOrCreate(
                    [
                        "persona_id"=>$persona->id,
                        "hospital_id"=>$personal->hospital_id,
                        "user_id"=>$user->id,
                    ],
                    [
                        
                        "estado_registro"=>"A"
                    ]
                );
            }
            
        }
        
        return response()->json(["resp"=>"creado correctamente"]);
    }
    public function update(Request $request,$idPersonal){
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $personal = Personal::find($idPersonal);
        if($hospital){
            if($personal->hospital_id == $hospital->id){
                $persona = Persona::updateOrCreate(
                    [
                        "tipo_documento_id"=>$request->tipo_documento_id,
                        "numero_documento"=>$request->numero_documento,
                    ],
                    [
                        "nombres"=>$request->nombres,
                        "apellido_paterno"=>$request->apellido_paterno,
                        "apellido_materno"=>$request->apellido_materno,
                        "telefono"=>$request->telefono,
                        "email"=>$request->email,
                        "grado_instruccion_id"=>$request->grado_instruccion_id,
                    ]
                );
                $user = User::updateOrCreate(
                    [
                        "username"=>$persona->numero_documento,
                        "persona_id"=>$persona->id,
                    ],
                    [
                        "password"=>$persona->numero_documento,
                    ]
                );
                $user_id = $personal->user_id;
                $user = User::with('roles')->find($user_id);
                
                $rol = Rol::find($request->rol_id);
                /*$users_roles = UserRol::where("estado_registro","A")->where('user_id',$user_id)->get();
                foreach($users_roles as $user_rol){
                    $userRol = UserRol::find($user_rol["id"]);
                    $userRol->estado_registro = "I";
                    $userRol->save();
                }*/
                $user_rol = UserRol::where('user_id',$user_id)->first();
                $user_rol->fill([
                    "user_id"=>$user->id,
                    "rol_id"=>$rol->id,
                    "estado_registro"=>"A",
                ])->save();
            }
        }
        return response()->json(["resp"=>"actualzado correctamente"]);
        
    }
    public function delete($idPersonal){
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $personal = Personal::find($idPersonal);
        if($hospital){
            if($personal->hospital_id == $hospital->id){
                $personal->estado_registro="I";
                $personal->save();
            }
        }
        return response()->json(["resp"=>"eliminado correctamente"]);
        
    }
    public function asignarCargo(Request $request){
        if($this->validar_acceso(2,"/personalHospital")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $personal = Personal::find($request->personal_id);
        if($hospital){
            if($personal->hospital_id == $hospital->id){
                $personal_cargo = PersonalCargo::updateOrCreate(
                    [
                        "personal_id"=>$request->personal_id,
                        "cargo_id"=>$request->cargo_id,
                        "hospital_id"=>$hospital->id,
                    ],
                    [
                        "estado_registro"=>"A"
                    ]
                );
                if ($request->hasFile('firma')) {
                    $path = $request->file('firma')->storeAs('public/firmas', $hospital->id . '-' . $request->personal_id. '-' . $request->cargo_id . '.' . $request->firma->extension());
                    $image = $hospital->id . '-' . $request->personal_id. '-' . $request->cargo_id. '.' . $request->firma->extension();
                } else {
                    $image = null;
                }
                $personal_cargo->firma = $image;
                $personal_cargo->save();
            }
        }
        return response()->json(["resp"=>"asignado correctamente"]);
    }
}
