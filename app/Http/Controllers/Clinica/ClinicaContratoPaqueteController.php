<?php

namespace App\Http\Controllers\Clinica;

use App\Http\Controllers\Controller;
use App\Models\ClinicaContratoPaquete;
use App\Models\Contrato;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ClinicaContratoPaqueteController extends Controller
{
    public function contrato_clinica_paquete_get(Request $request)
    {
        try {
            $user = User::with('user_rol.rol')->where('id', auth()->user()->id)->first();
            $clinica_id = $user->user_rol[0]->rol->clinica_id;
            if ($clinica_id) {
                
                /*$contrato = Contrato::where("clinica_id", $clinica_id)
                    ->where("bregma_id", null)
                    ->get();*/
                $contrato_paquete = ClinicaContratoPaquete::with("clinica_paquete.clinica_servicio")
                ->where("contrato_id",$request->id_contrato)
                ->get();
                /*$paquete_servicio = ClinicaContratoPaquete::where('contrato', $contrato->id)
                    ->get();*/
                return response()->json($contrato_paquete);
            } else {
                return response()->json("No eres usuario clinica");
            }
        } catch (Exception $e) {
            return response()->json(["resp" => "Error  " . $e], 400);
        }
    }
}
