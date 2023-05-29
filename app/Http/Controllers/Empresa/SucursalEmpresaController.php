<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Sucursal;
use App\User;

class SucursalEmpresaController extends Controller
{
    public function admin()
    {
        $admin_empresa = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($admin_empresa->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 3 && $accesos['url'] == "/sucursalEmpresa") {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    public function get()
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $empresa = Empresa::where('ruc',$usuario->username)->first();
        $sucursales = Sucursal::with(["distrito", "provincia.distritos", "departamento.provincias.distritos"])->where("empresa_id", $empresa->id)->where("estado_registro", "A")->get();
        return response()->json(["data" => $sucursales, "size" => count($sucursales)]);
    }
    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $empresa = Empresa::where('ruc',$usuario->username)->first();
        $sucursal = Sucursal::updateOrCreate([
            "empresa_id" => $empresa->id,
            "nombre" => $request->nombre,
        ], [
            "estado_registro" => "A",
            "direccion" => $request->direccion,
            "distrito_id" => $request->distrito_id,
            "provincia_id" => $request->provincia_id,
            "departamento_id" => $request->departamento_id,
            "latitud" => $request->latitud,
            "longitud" => $request->longitud,
        ]);
        return response()->json(["resp" => "Creado correctamente"]);
    }
    public function update(Request $request, $idSucursal)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $sucursal = Sucursal::find($idSucursal);
        $sucursal->fill([
            "nombre" => $request->nombre,
            "direccion" => $request->direccion,
            "distrito_id" => $request->distrito_id,
            "provincia_id" => $request->provincia_id,
            "departamento_id" => $request->departamento_id,
            "latitud" => $request->latitud,
            "longitud" => $request->longitud,
        ])->save();
        return response()->json(["resp" => "actualizado correctamente"]);
    }
    public function show($idSucursal)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $sucursal = Sucursal::with(["distrito"])->find($idSucursal);
    }
    public function delete($idSucursal)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $sucursal = Sucursal::find($idSucursal);
        $sucursal->fill([
            "estado_registro" => "I",

        ])->save();
        return response()->json(["resp" => "eliminado correctamente"]);
    }
}
