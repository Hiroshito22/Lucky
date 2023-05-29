<?php

namespace App\Http\Controllers;

use App\Models\TipoTrabajador;
use Illuminate\Http\Request;

class TipoTrabajadorController extends Controller
{
    public function get()
    {
        $tipo_trabajador = TipoTrabajador::where('estado_registro','A')->get();
        return response()->json(["data"=>$tipo_trabajador,"size"=>count($tipo_trabajador)], 200);
    }
    
}
