<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create(Request $request){
        DB::beginTransaction();
        try {
            $persona = Persona::firstOrCreate(
                [
                    "tipo_documento_id"=>1,
                    "numero_documento"=>$request->numero_documento,
                ],
                [
                    "nombres"=>$request->nombres,
                    "apellido_paterno"=>$request->apellido_paterno,
                    "apellido_materno"=>$request->apellido_materno,
                    "celular"=>$request->celular,
                    "correo"=>$request->correo,
                    "distrito_id"=>$request->distrito_id,
                ]
            );
            $usuario = User::firstOrCreate(
                [
                    "persona_id"=>$persona->id,
                    "username"=>$persona->numero_documento,
                ],
                [
                    "password"=>$persona->numero_documento,
                ]
            );
        DB::commit();
        return response()->json(["resp" => "Usuario creado correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
}
