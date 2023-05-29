<?php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Atencion;
use App\Models\Paciente;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtencionController extends Controller
{
    public function startAtencion($idAtencion)
    {
        DB::commit();
        try {
            $atencion = Paciente::find($idAtencion);
            // return response()->json($idAtencion);
            $atencion->estado_atencion=1; //1 empezo atencion
            $atencion->save();
            DB::commit();
            return response()->json(["resp"=>"Atencion empezada correctamente"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["resp"=>"Aglo salió mal", "err"=>"".$e]);
        }

    }

    public function getAtenciones()
    {
        $usuario = User::find(auth()->user()->id)->roles;

        $pacientes = Paciente::join('persona', 'paciente.persona_id', 'persona.id')
            ->join('tipo_documento', 'persona.tipo_documento_id', 'tipo_documento.id')
            ->select('paciente.*','tipo_documento.nombre', 'fecha_nacimiento', 'numero_documento', DB::raw("CONCAT(persona.nombres,' ',persona.apellido_paterno,' ',apellido_materno) as nombres_completos"))
            ->with(['hoja_ruta.areas_medicas.area_medica'])
            ->where('clinica_id', $usuario[0]->clinica_id)
            ->where('estado_atencion',1)
            ->get();

        return response()->json(["data"=>$pacientes,"size"=>count($pacientes)]);
    }
}
