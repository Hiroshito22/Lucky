<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\ClinicaPaquete;
use App\User;
use Illuminate\Http\Request;

class EmpresaPaqueteController extends Controller
{
    public function getRutinaSalida($id)
    {
        $user = User::with('persona','user_rol.rol.acceso_rol.acceso','roles.accesos')->find(auth()->user()->id);

        $clinica_paquetes = ClinicaPaquete::with(['perfil_tipos.tipo_perfil'])->get();
        return response()->json(["data" => $clinica_paquetes, "size" => count($clinica_paquetes)]);
    }
}
