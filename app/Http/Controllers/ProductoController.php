<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Trabajador;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();
            $perosna = Persona::where();
            $trabajador = Trabajador::where('rol_id', 2)->where("persona_id",)->first();
        }catch(Exception $e){}
    }
}
