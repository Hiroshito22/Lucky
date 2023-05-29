<?php

namespace App\Http\Controllers;

use App\Models\TipoHabito;
use Illuminate\Http\Request;

class TipoHabitoController extends Controller
{
    public function get()
    {
        $tipos_habito = TipoHabito::get();
        return response()->json(["data" => $tipos_habito, "size" => count($tipos_habito)]);
    }
}
