<?php

namespace App\Http\Controllers;

use App\Models\GradoInstruccion;
use Illuminate\Http\Request;

class GradoInstruccionController extends Controller
{
    public function get()
    {
        $grado_instruccion = GradoInstruccion::get();
        return response()->json(["data"=>$grado_instruccion,"size"=>count($grado_instruccion)], 200);
    }
}
