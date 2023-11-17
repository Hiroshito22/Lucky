<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = User::with('persona')->where('id', auth()->user()->id)->first();
            $empresa = Empresa::create([
                "numero_documento" => $request->numero_documento,
                "razon_social" => $request->razon_social,
                "logo" => $request->logo,
                "distrito_id" => $request->distrito_id,
                "direccion_legal" => $request->direccion_legal
            ]);
            DB::commit();
            return response()->json(["resp" => "Empresa creado correctamente"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["error" => "error " . $e], 500);
        }
    }
}
