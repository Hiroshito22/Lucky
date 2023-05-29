<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Material;
use App\User;
use Illuminate\Http\Request;

class MaterialController extends Controller
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
        $hospital = Hospital::where('numero_documento',$usuario->username)->first();

        $materiales = Material::where('hospital_id',$hospital->id)->where('estado_registro','A')->get();
        return response()->json(["data"=>$materiales,"size"=>count($materiales)]);
    }

    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento',$usuario->username)->first();

        //return response()->json($hospital);

        $material = Material::updateOrCreate(
            [
                "nombre" => $request->nombre,
                "hospital_id" => $hospital->id,
            ],
            [
                'estado_registro' => 'A',
                "stock" => $request->stock
            ]
        );
        return response()->json(["resp"=>"Se creo correctamente"]);
    }

    public function update(Request $request,$idMaterial)
    {
        $material = Material::find($idMaterial);
        $material->fill(
            [
                "nombre" => $request->nombre,
                "stock" => $request->stock
            ]
        )->save();
        return response()->json(["resp"=>"Se eliminó correctamente"]);
    }

    public function delete($idMaterial)
    {
        $material = Material::find($idMaterial);
        $material->fill(
            [
                "estado_registro" => "I"
            ]
        )->save();
        return response()->json(["resp"=>"Se eliminó correctamente"]);
    }
}
