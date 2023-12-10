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
                    //'direccion_legal' => $request->direccion_legal,
                    'persona_id' => $persona->id,
                ], [
                    //'direccion_legal' => $request->direccion_legal,
                    'rol_id' => $request->rol_id,
                    'empresa_id'=> 1,
                    'estado_registro' => 'A'
                ]);
        DB::commit();
        return redirect()->back()->with('success', 'Datos guardados exitosamente.');
        //return response()->json(["resp" => "Personal creado correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function update(Request $request,$id_trabajador){
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $persona = Trabajador::where('id', $id_trabajador)->first();
            $persona->fill([
                //'direccion_legal' => $request->direccion_legal,
                'rol_id' => $request->rol_id,
                'empresa_id'=> 1,
            ])
            ->save();
        DB::commit();
        return response()->json(["resp" => "Personal actualizado correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function delete($id_trabajador){
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $persona = Trabajador::find($id_trabajador);
            $persona->fill([
                "estado_registro" => "I",
            ])->save();
        DB::commit();
        return response()->json(["resp" => "Personal eliminada correctamente"], 200);
    }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }

    public function get()
    {
        try {
            $usuario = User::with('persona')->where('id', auth()->user()->id)->first();

            $trabajador = Trabajador::where('estado_registro', 'A')->get();

            return response()->json(["data" => $trabajador, "size" => (count($trabajador))], 200);
        } catch (Exception $e) {
            return response()->json(["resp" => "error", "error" => "Error al llamar a los trabajadores  " . $e], 400);
        }
    }
}
