<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Imports\TrabajadorImport;
use App\User;
use App\Models\UserRol;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TrabajadorController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 3 && $accesos['url'] == "/trabajadorEmpresa") {
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
        $trabajadores = Trabajador::where('empresa_id',$empresa->id)
        ->with("persona.tipo_documento", "subarea.area.superarea", "sucursal.distrito", "sucursal.provincia.distritos", "sucursal.departamento.provincias.distritos", "cargo", "tipo_trabajador")
        ->where('estado_registro', 'A')
        ->get();
        return response()->json(["data" => $trabajadores, "size" => count($trabajadores)]);
    }
    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }

        $persona = Persona::firstOrCreate(
            [
                "tipo_documento_id" => $request->tipo_documento_id,
                "numero_documento" => $request->numero_documento,
            ],
            [
                "nombres" => $request->nombres,
                "apellido_paterno" => $request->apellido_paterno,
                "apellido_materno" => $request->apellido_materno,
                "sexo_id" => $request->sexo_id,
            ]
        );

        $user = User::firstOrCreate(
            [
                "username" => $request->numero_documento,
                "persona_id" => $persona->id
            ],
            [
                "password" => $request->numero_documento,
            ]
        );

        $user_rol_trabajador = UserRol::updateOrCreate(
            [
                "user_id" => $user->id,
                "rol_id" => 3,
            ],
            [
                "estado_registro" => "A"
            ]
        );

        $usuario = User::with('roles')->find(auth()->user()->id);
        $empresa = Empresa::where('ruc',$usuario->username)->first();

        $trabajador = Trabajador::updateOrCreate(
            [
                "empresa_id" => $empresa->id,
                "persona_id" => $persona->id,
                "user_rol_id" => $user_rol_trabajador->id,
            ],
            [
                "subarea_id" => $request->subarea_id,
                "sucursal_id" => $request->sucursal_id,
                "cargo_id" => $request->cargo_id,
                "tipo_trabajador_id" => $request->tipo_trabajador_id,
                "estado_registro" => "A",
                "estado_trabajador" => null,
            ]
        );
        return response()->json(["resp" => "trabajador creado"]);
    }
    public function update($idTrabajador, Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }

        $trabajador = Trabajador::find($idTrabajador);

        $persona = Persona::find($trabajador->persona_id);
        $persona->fill([
            "nombres" => $request->nombres,
            "apellido_paterno" => $request->apellido_paterno,
            "apellido_materno" => $request->apellido_materno,
            "sexo_id" => $request->sexo_id,
            "tipo_documento_id" => $request->tipo_documento_id,
            "numero_documento" => $request->numero_documento,
        ])->save();
        $user_rol_trabajador = UserRol::find($trabajador->user_rol_id);
        $user_rol_trabajador->fill([
            "rol_id" => 3,
            "estado_registro" => "A"
        ])->save();
        $user = User::find($user_rol_trabajador->user_id);
        $user->fill(
            [
                "username" => $request->numero_documento,
                "password" => $request->numero_documento,
            ]
        )->save();

        $trabajador->fill(
            [
                "subarea_id" => $request->subarea_id,
                "sucursal_id" => $request->sucursal_id,
                "cargo_id" => $request->cargo_id,
                "tipo_trabajador_id" => $request->tipo_trabajador_id,
                "estado_registro" => "A",
                "estado_trabajador" => null,
            ]
        )->save();
        return response()->json(["resp" => "trabajador Actualizado correctamente"]);
    }
    public function delete($idTrabajador)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }

        $trabajador = Trabajador::find($idTrabajador);
        $user_rol_trabajador = UserRol::find($trabajador->user_rol_id);
        $user_rol_trabajador->fill([
            "estado_registro" => "I"
        ])->save();

        $trabajador->fill([
            "estado_registro" => "I",
        ])->save();
        return response()->json(["resp" => "trabajador eliminado correctamente"]);
    }
    public function import(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        Excel::import(new TrabajadorImport, $request->file);
        return response()->json(["resp" => "importado"]);
    }
}
