<?php

namespace App\Http\Controllers\Empresa;
use App\Http\Controllers\Controller;

use App\Models\Cargo;
use App\Models\Empresa;
use App\User;
use Exception;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function admin()
    {
        $admin_empresa = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($admin_empresa->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 3 && $accesos['url'] == "/cargosEmpresa") {
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
        $cargos = Cargo::where('empresa_id',$empresa->id)->where('estado_registro', 'A')->get();
        return response()->json(["data" => $cargos, "size" => count($cargos)], 200);
    }
    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        try {
            $usuario = User::with('roles')->find(auth()->user()->id);
            $empresa = Empresa::where('ruc',$usuario->username)->first();
            $cargo = Cargo::updateOrCreate(
                [
                    'nombre' => $request->nombre,
                    'empresa_id' => $empresa->id,
                ],
                [
                    'descripcion' => $request->descripcion,
                    'estado_registro' => 'A'
                ]
            );
            return response()->json(["resp" => "Se creó correctamente"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "No se creó correctamente"]);
        }
    }
    public function update($idCargo, Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        try {
            $cargo = Cargo::find($idCargo);
            $cargo->fill(
                [
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'estado_registro' => 'A'
                ]
            )->save();
            return response()->json(["resp" => "Se actualizó correctamente"]);
        } catch (Exception $e) {
            return response()->json(["resp" => "No se actualizó correctamente"]);
        }
    }
    public function delete($idCargo)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        try {
            $cargo = Cargo::find($idCargo);
            $cargo->fill(
                [
                    'estado_registro' => 'I'
                ]
            )->save();
            return response()->json(["resp" => "Se eliminó correctamente"]);

        } catch (Exception $e) {
            return response()->json(["resp" => "No se eliminó correctamente"]);
        }
    }
}
