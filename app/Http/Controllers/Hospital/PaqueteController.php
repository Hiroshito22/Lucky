<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\ClinicaServicio;
use App\Models\Hospital;
use App\Models\Paquete;
use App\Models\PaqueteServicio;
use App\Models\ProductoPaquete;
use App\User;
use Illuminate\Http\Request;

class PaqueteController extends Controller
{
    public function admin()
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == 2 && $accesos['url'] == "/paquetes") {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }
    public function index()
    {
        // if ($this->admin() == false) {
        //     return response()->json(["resp" => "no tiene accesos"]);
        // }
        $usuario = User::with('roles')->find(auth()->user()->id);
        $hospital = Hospital::where('numero_documento',$usuario->username)->first();

        $paquetes = Paquete::with(['servicios'])->where("estado_registro", 'A')->get();
        return response()->json(["data" => $paquetes, "size" => count($paquetes)]);
    }

    public function create(Request $request)
    {

        // if ($this->admin() == false) {
        //     return response()->json(["resp" => "no tiene accesos"]);
        // }
        // $usuario = User::with('roles')->find(auth()->user()->id);
        // $hospital = Hospital::where('numero_documento',$usuario->username)->first();
        $paquete = Paquete::updateOrCreate(
            [
                "nombre" => $request->nombre,
                // "hospital_id" => $hospital->id
            ],
            [
                "precio" => $request->precio,
                "estado_registro" => 'A',
            ]
        );
        $servicios = $request->clinicas_servicios;

        foreach ($servicios as $servicio ) {
            PaqueteServicio::create([
                'paquete_id' => $paquete->id,
                'clinica_servicio_id' => $servicio['id']
            ]);
         }
        return response()->json(["resp" => "paquete creado"]);
    }

    public function changeEstadoDelivery($idPaquete)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete = Paquete::find($idPaquete);
        if($paquete->estado_delivery === "1"){
            $paquete->estado_delivery = '0';
        } else {
            $paquete->estado_delivery = '1';
        }
        $paquete->save();
        return response()->json(["resp" => "Paquete editado correctamente"]);
    }

    public function show($idPaquete)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete = Paquete::with(["paquete_productos.producto.producto_servicios.servicio"])->where("estado_registro", 'A')->find($idPaquete);
        return response()->json($paquete);
    }

    public function destroy($idPaquete)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete = Paquete::find($idPaquete);
        $paquete->estado_registro = 'I';
        $paquete->save();
        return response()->json(["resp" => "paquete eliminado"]);
    }

    public function update(Request $request, $idPaquete)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $paquete = Paquete::find($idPaquete);
        $verify_name_paquet = Paquete::where("id", '!=', $idPaquete)->where("nombre", $request->nombre)->where("estado_registro", "A")->first();
        if ($verify_name_paquet) {
            return response()->json(["resp" => "nombre del paquete ya esta en uso"]);
        }
        $paquete->fill([
            "nombre" => $request->nombre,
            "precio" => $request->precio,
        ])->save();

        return response()->json(["resp" => "Paquete actualizado correctamente"]);
    }

    public function getProductos($idPaquete)
    {
        if ($this->admin() == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $producto_paquete = ProductoPaquete::with(['producto', 'paquete'])->where('paquete_id', $idPaquete)->where('estado_registro', 'A')->get();
        return response()->json(["data" => $producto_paquete, "size" => count($producto_paquete)]);
    }
}
