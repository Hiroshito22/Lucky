<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\EmpresaPaquete;
use App\Models\Paquete;
use App\User;
use Illuminate\Http\Request;

class EmpresaPaqueteController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == '/paquetes') {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }

    public function get()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 3 && $accesos['url']== '/atenciones') {
                    $valido = true;
                }
            }
        }
        if (!$valido) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $empresa = Empresa::where('ruc',$usuario->username)->first();
        $paquetes = EmpresaPaquete::where('empresa_id',$empresa->id)->with(['empresa', 'paquete'])->where("estado_registro", 'A')->get();
        return response()->json(["data" => $paquetes, "size" => count($paquetes)]);
    }

    public function create(Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete = Paquete::find($request->paquete_id);
        if (!$paquete || $paquete->estado_registro == 'I') {
            return response()->json(["resp" => "el paquete no existe"], 400);
        }
        $empresa_paquete = EmpresaPaquete::updateOrCreate(
            [
                "empresa_id" => $request->empresa_id,
                "paquete_id" => $request->paquete_id,
            ],
            [
                "precio" => $request->precio,
                "estado_registro" => 'A',
            ]
        );

        return response()->json(["resp" => "paquete creado"]);
    }

    public function show($idPaqueteEmpresa)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete_empresa = EmpresaPaquete::with(['empresa', 'paquete', 'historial_paquete_precios'])->where("estado_registro", 'A')->find($idPaqueteEmpresa);
        return response()->json($paquete_empresa);
    }

    public function update(Request $request, $idPaqueteEmpresa)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete_empresa = EmpresaPaquete::find($idPaqueteEmpresa);
        $paquete_empresa->fill([
            "precio" => $request->precio,
        ])->save();

        return response()->json(["resp" => "paquete actualizado"]);
    }

    public function delete($idPaqueteEmpresa)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete_empresa = EmpresaPaquete::find($idPaqueteEmpresa);
        $paquete_empresa->estado_registro = 'I';
        $paquete_empresa->save();
        return response()->json(["resp" => "paquete eliminado"]);
    }
}
