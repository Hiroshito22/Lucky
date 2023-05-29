<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AtencionServicio;
class FichaOcupacionalController extends Controller
{
    public function startAtention(Request $request){
        $atencion_servicio=AtencionServicio::where('servicio_id',$request->servicio_id)->where('atencion_id',$request->atencion_id)->first();
        $atencion_servicio->fill([
            "hora_inicio"=>date("H:i:s"),
            "estado_atencion"=>1
        ])->save();
        return response()->json(["resp"=>"Atención iniciada"]);
    }
}
