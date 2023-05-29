<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Hospital;
use App\Models\Liquidacion;
use App\Models\Atencion;
use App\Models\LiquidacionDetalle;

class LiquidacionController extends Controller
{
    public function admin($tipo_acceso,$url)
    {
        $superadmin = User::with('persona', 'user_rol.rol.acceso_rol.acceso', 'roles.accesos')->find(auth()->user()->id);
        $valido = false;
        foreach ($superadmin->roles as $roles) {
            foreach ($roles->accesos as $accesos) {
                if ($accesos['tipo_acceso'] == $tipo_acceso && $accesos['url'] == $url) {
                    return $valido = true;
                }
            }
        }
        return $valido;
    }
    public function get(){
        if ($this->admin(2,'/facturacion/liquidacion') == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $liquidaciones = Liquidacion::with('empresa.tipo_documento','liquidacion_detalle.atencion.trabajador.persona.tipo_documento','liquidacion_detalle.atencion.paquete','liquidacion_detalle.atencion.atencion_servicio','liquidacion_detalle.atencion.empresa.tipo_documento')->where('hospital_id',$hospital->id)->where('estado_registro','A')->get();
        }
        return response()->json(["data"=>$liquidaciones,"size"=>count($liquidaciones)]);
    }
    public function create(Request $request){
        if ($this->admin(2,'/facturacion/costo') == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $liquidacion = Liquidacion::create([
                "total"=>$request->total,
                "subtotal"=>$request->subtotal,
                "igv"=>$request->igv,
                "empresa_id"=>$request->empresa_id,
                "hospital_id"=>$hospital->id,
                "particular_id"=>$request->particular_id,
                "estado_registro"=>"A",
                "estado_pago"=>0,
                "observaciones"=>$request->observaciones,
                "fecha_emision"=>$request->fecha_emision
            ]);
            $liquidacion_detalle = $request->liquidacion_detalle;
            foreach($liquidacion_detalle as $detalle){
                $atencion = Atencion::find($detalle['id']);
                $liquidacion_det= LiquidacionDetalle::create([
                    "atencion_id"=>$atencion->id,
                    "liquidacion_id"=>$liquidacion->id,
                    "subtotal"=>$atencion->subtotal,
                    "total"=>$atencion->total,
                    "igv"=>$atencion->igv,
                    "estado_registro"=>"A",
                ]);
                $atencion->fill([
                    "estado_atencion"=>1
                ])->save();
            }
        }
        return response()->json(["resp"=>"Liquidacion Creada"]);
    }
    public function update(Request $request,$idLiquidacion){
        if ($this->admin(2,'/facturacion/costo') == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        if($hospital){
            $liquidacion = Liquidacion::find($idLiquidacion);
            $liquidacion->fill([
                "total"=>$request->total,
                "subtotal"=>$request->subtotal,
                "igv"=>$request->igv,
                "observaciones"=>$request->observaciones,
                "fecha_emision"=>$request->fecha_emision
            ])->save();
        }
        $liquidacion_detalle = LiquidacionDetalle::where('liquidacion_id',$liquidacion->id)->get();
        foreach($liquidacion_detalle as $detalle){
            $liq_det = LiquidacionDetalle::find($detalle['id']);
            $liq_det->fill([
                "estado_registro"=>"I"
            ])->save();
            $atencion = Atencion::find($liq_det->atencion_id);
            $atencion->fill([
                "estado_atencion"=>0
            ])->save();
        }
        $liquidacion_detalle = $request->liquidacion_detalle;
        foreach($liquidacion_detalle as $detalle){
                $atencion = Atencion::find($detalle['id']);
                $liquidacion_det= LiquidacionDetalle::updateOrCreate([
                    "atencion_id"=>$atencion->id,
                    "liquidacion_id"=>$liquidacion->id,
                    
                    
                ],
                [
                    "subtotal"=>$atencion->subtotal,
                    "total"=>$atencion->total,
                    "igv"=>$atencion->igv,
                    "estado_registro"=>"A",
                ]);
                $atencion->fill([
                    "estado_atencion"=>1
                ])->save();
            }
        
    }
    public function subirFactura(Request $request,$idLiquidacion){
         if ($this->admin(2,'/facturacion/costo') == false) {
            return response()->json(["resp" => "no tiene accesos"]);
        }
        $admin_hospital = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);
        $hospital = Hospital::where("numero_documento",$admin_hospital->persona->numero_documento)->first();
        $liquidacion = Liquidacion::find($idLiquidacion);
        
        if ($request->hasFile('factura')) {
            
            $path = $request->file('factura')->storeAs('public/facturas', $liquidacion->id . '.' . $request->factura->extension());
            
            $image = $liquidacion->id . '.' . $request->factura->extension();
            
            $liquidacion->factura = $image;
            
            $liquidacion->save();
        }
        return response()->json(["resp"=>"subido correctamente"]);
    }
}
