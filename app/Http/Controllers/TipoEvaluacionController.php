<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoEvaluacion;
class TipoEvaluacionController extends Controller
{
    public function get(){
        $tipo_evaluaciones = TipoEvaluacion::get();
        return response()->json(["data"=>$tipo_evaluaciones,"size"=>count($tipo_evaluaciones)]);
    }
}
