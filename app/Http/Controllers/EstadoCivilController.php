<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use Illuminate\Http\Request;

class EstadoCivilController extends Controller
{
    public function get()
    {
        $estado_civil = EstadoCivil::get();
        return response()->json(["data"=>$estado_civil,"size"=>count($estado_civil)], 200);
    }
}
