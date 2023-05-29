<?php

namespace App\Http\Controllers;

use App\Models\Frecuencia;
use Illuminate\Http\Request;

class FrecuenciaController extends Controller
{
    public function get()
    {
        $frecuencias = Frecuencia::get();
        return response()->json(["data"=>$frecuencias,"size"=>count($frecuencias)]);
    }
}
