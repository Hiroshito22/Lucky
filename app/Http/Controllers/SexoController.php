<?php

namespace App\Http\Controllers;

use App\Models\Sexo;
use Illuminate\Http\Request;

class SexoController extends Controller
{
    public function get()
    {
        $sexo = Sexo::get();
        return response()->json(["data"=>$sexo,"size"=>count($sexo)], 200);
    }
}
