<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patologia;
use App\User;
use App\Models\HospitalPatologia;
use App\Models\Hospital;
class PatologiaController extends Controller
{

    public function get_patologias()
    {
        $patologias = Patologia::where('tipo_patologia_id',2)->orderBy('nombre','asc')->get();
        return response()->json(["resp" => $patologias]);
    }

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
        if($this->validar_acceso(2,"/patologias")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $patologias = HospitalPatologia::with('patologia.tipo_patologia')->where('hospital_id',$hospital->id)->where('estado_registro','!=','I')->get();
        }
        return response()->json(["data"=>$patologias,"size"=>count($patologias)]);

    }

    public function create(Request $request){
        if($this->validar_acceso(2,"/patologias")==false){
            return response()->json(["resp"=>"no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $patologia = Patologia::updateOrCreate(
                [
                    "nombre"=>$request->nombre,
                    "hospital_id"=>$hospital->id,
                    "tipo_patologia_id"=>$request->tipo_patologia_id,
                ],
                [
                    "estado_registro"=>"A"
                ]
            );
            $hospital_patologia = HospitalPatologia::updateOrCreate(
                [
                    "patologia_id"=>$patologia->id,
                    "hospital_id"=>$hospital->id,
                ],
                [
                    "estado_registro"=>"A",
                    "activo"=>1
                ]
            );

        }
        return response()->json(["resp"=>"creado correctamente"]);

    }
    public function update($idHospitalPatologia, Request $request)
    {
        if($this->validar_acceso(2,"/patologias")==false){
            return response()->json(["resp"=>"no tiene accesos"],500);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $patologia_hospital = HospitalPatologia::find($idHospitalPatologia);
        if($hospital){
            if($patologia_hospital->hospital_id==$hospital->id && $patologia_hospital->estado_registro!='SU'){
                $patologia = Patologia::find($patologia_hospital->patologia_id);
                $patologia->fill([
                    "nombre"=>$request->nombre,
                ])->save();
            }else{
                return response()->json(["resp" => "No puede editar esta patologia"],500);
            }

        }
        return response()->json(["resp" => "Se edito correctamente"]);
    }
    public function delete($idHospitalPatologia){
        if($this->validar_acceso(2,"/patologias")==false){
            return response()->json(["resp"=>"no tiene accesos"],500);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $patologia_hospital = HospitalPatologia::find($idHospitalPatologia);
        if($hospital){
            if($patologia_hospital->hospital_id==$hospital->id && $patologia_hospital->estado_registro!='SU'){
                $patologia = Patologia::find($patologia_hospital->patologia_id);
                $patologia->fill([
                    "estado_registro"=>"I",
                ])->save();
                $patologia_hospital->estado_registro="I";
                $patologia_hospital->save();
            }else{
                return response()->json(["resp" => "No puede eliminar esta patologia"],500);
            }

        }
        return response()->json(["resp" => "Se Elimino correctamente"]);
    }
    public function activar_desactivar($idHospitalPatologia)
    {
        if($this->validar_acceso(2,"/patologias")==false){
            return response()->json(["resp"=>"no tiene accesos"],500);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $patologia_hospital = HospitalPatologia::find($idHospitalPatologia);
        if($hospital){
            if($patologia_hospital->hospital_id==$hospital->id){
                if($patologia_hospital->activo==1){
                    $patologia_hospital->activo=0;
                }
                else{
                    $patologia_hospital->activo=1;
                }
                $patologia_hospital->save();
            }else{
                return response()->json(["resp" => "Error de accesos"],500);
            }

        }
        return response()->json(["resp" => "Se edito correctamente"]);
    }
}
