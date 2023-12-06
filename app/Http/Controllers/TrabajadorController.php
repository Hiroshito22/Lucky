<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Trabajador;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrabajadorController extends Controller
{
    public function create(Request $request){
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $persona = Persona::where('numero_documento', $request->numero_documento)->first();
            if ($persona) {
                $existe_personal_empresa = Trabajador::where('persona_id', $persona->id)->where('estado_registro', 'A')->first();
                if ($existe_personal_empresa) {
                    return response()->json(["error" => "Ya existe otro registro con el numero de documento"], 500);
                }
            }
                $usuario = User::updateOrCreate([
                    'persona_id' => $persona->id,
                    'username' => $persona->numero_documento,
                ], [
                    'password' => $persona->numero_documento,
                    'estado_registro' => 'A'
                ]);
                $personal = Trabajador::updateOrCreate([
                    'direccion_legal' => $request->direccion_legal,
                    'persona_id' => $persona->id,
                ], [
                    'direccion_legal' => $request->direccion_legal,
                    'rol_id' => $request->rol_id,
                    'empresa_id'=>$request->empresa_id,
                    'estado_registro' => 'A'
                ]);
        DB::commit();
        return response()->json(["resp" => "Personal creado correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    
}