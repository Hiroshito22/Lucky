<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Acceso;
use App\Models\AccesoRol;
use App\Models\Empresa;
use App\Models\EmpresaPaquete;
use App\Models\Hospital;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\UserRol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class EmpresaController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == '/empresas') {
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
        $empresa = Empresa::with(['user_rol', 'tipo_documento', 'distrito.provincia.departamento','mis_paquetes.paquete'])->where('hospital_id',$hospital->id)->where('estado_registro', '=', 'A')->get();
        return response()->json(['data' => $empresa, 'size' => count($empresa)], 200);
    }

    public function create(Request $request)
    {
        if ($this->admin() == false) return response()->json(["resp" => "no tiene accesos"]);
        DB::beginTransaction();
        try {
            $existe_ruc = Empresa::where('ruc', $request->ruc)->where('estado_registro', 'A')->first();
            if ($existe_ruc) return response()->json(["resp" => "empresa existe"], 401);

            $persona = Persona::firstOrCreate(
                [
                    'tipo_documento_id' => 2,
                    "numero_documento" => $request->ruc,
                ],
                [
                    'nombres' => $request->razon_social
                ]
            );

            //return response()->json($persona);
            $usuario = User::firstOrCreate(
                [
                    "username" => $request->ruc,
                    "persona_id"=>$persona->id,
                ],
                [
                    "password" => $request->ruc,
                    "estado_registro" => "A"
                ]
            );

            $rol = Rol::firstOrCreate(
                [
                    "nombre"=>"Administrador Empresa",
                    "tipo_acceso" => 3,
                ],[
                    "estado_registro"=>"AD"
                ]
            );

            $usuario_rol = UserRol::updateOrCreate(
                [
                    "user_id" => $usuario->id,
                    "rol_id" => $rol->id,
                ],
                [
                    "tipo_rol" => 3,
                    "estado_registro" => "A"
                ]
            );
            $usuario = User::with('roles')->find(auth()->user()->id);
            $hospital = Hospital::where('numero_documento',$usuario->username)->first();
            $empresa = Empresa::updateOrCreate(
                [
                    'tipo_documento_id' => $request->tipo_documento_id,
                    'ruc' => $request->ruc,
                    'hospital_id' => $hospital->id
                ],
                [
                    'razon_social' => $request->razon_social,
                    'nombre_comercial' => $request->nombre_comercial,
                    'responsable' => $request->responsable,
                    'distrito_id' => $request->distrito_id,
                    'direccion' => $request->direccion,
                    'latitud' => $request->latitud,
                    'longitud' => $request->longitud,
                    'estado_registro' => "A",
                ]
            );

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->storeAs('public/empresa', $empresa->id . '-' . $request->ruc . '.' . $request->logo->extension());
                $image = $empresa->id . '-' . $request->ruc . '.' . $request->logo->extension();
            } else {
                $image = null;
            }
            $empresa->logo = $image;
            $empresa->save();

            $accesos = Acceso::where('tipo_acceso',3)->get();
            foreach ($accesos as $acceso ) {
                AccesoRol::firstOrCreate(
                    [
                        "acceso_id"=>$acceso['id'],
                        "rol_id"=>$rol->id
                    ],[]
                );
            }

            //falta historial de trabajdor
            DB::commit();
            return response()->json(["resp" => "Se creo correctamente"]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "error", "error" => $e], 500);
        }
    }
    public function show($idEmpresa)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $empresa = Empresa::with(['tipo_empresa', 'rubro', 'distrito.provincia_departamento'])->where("estado_registro", 'A')->find($idEmpresa);
        return response()->json($empresa);
    }

    /*public function getPaquetes($idEmpresa){
        $paquetes = EmpresaPaquete::with(['empresa','paquete'])->where('empresa_id',$idEmpresa)->where("estado_registro",'A')->get();
        return response()->json(["data"=>$paquetes,"size"=>count($paquetes)]);
    }*/

    public function update($empresa_id, Request $request)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $empresa = Empresa::findOrfail($empresa_id);
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->storeAs('public/empresa', $empresa->id . '-' . $request->ruc . '.' . $request->logo->extension());
            $image = $empresa->id . '-' . $request->ruc . '.' . $request->logo->extension();
            $empresa->logo = $image;
            $empresa->save();
        }
        $empresa->fill(
            [
                "ruc" => $request->ruc,
                'tipo_documento_id' => $request->tipo_documento_id,
                'razon_social' => $request->razon_social,
                'nombre_comercial' => $request->nombre_comercial,
                'responsable' => $request->responsable,
                'distrito_id' => $request->distrito_id,
                'direccion' => $request->direccion,
                'estado_registro' => "A",
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
            ]
        )->save();
        return response()->json(["resp" => "Se edito correctamente"]);
    }
    public function destroy($empresa_id)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $empresa = Empresa::findOrfail($empresa_id);
        $empresa->estado_registro = 'I';

        $empresa->save();
        return response()->json(["resp" => "Se elimino la empresa correctamente"]);
    }
    public function me($idEmpresa)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $empresa = Empresa::with(['sucursal_empresa', 'superareas.areas.subareas.empresa_paquetes_subarea.empresa_paquete.paquete'])->find($idEmpresa);
        return response()->json($empresa);
    }
    public function getPaquetes($idEmpresa)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquetes = EmpresaPaquete::with(['empresa', 'paquete'])->where('empresa_id', $idEmpresa)->where("estado_registro", 'A')->get();
        return response()->json(["data" => $paquetes, "size" => count($paquetes)]);
    }
}
