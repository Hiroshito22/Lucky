<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atencion;
use App\Models\HistoriaClinica;
use App\Models\FichaOcupacional;
use App\Models\FoAPersonal;
use App\Models\HospitalPatologia;
use App\Models\FoPersonalPatologia;
use App\Models\AtencionServicio;
class FoAPersonalController extends Controller
{
    public function create(Request $request){
        $atencion = Atencion::with('trabajador')->find($request->atencion_id);
        
        if($atencion->trabajador_id){
            $persona_id=$atencion->trabajador->persona_id;
            
        }
        if($atencion->persona_id){
            $persona_id=$atencion->persona_id;
        }
        $historia_clinica = HistoriaClinica::where('persona_id',$persona_id)->first();
        $ficha_ocupacional = FichaOcupacional::firstOrCreate(
            [
                "atencion_id"=>$atencion->id,
            ],
            [
                "fecha_emision"=>date("Y-m-d"),
                "estado_registro"=>"A",
                "tipo_evaluacion_id"=>$atencion->tipo_evaluacion_id,
                "historia_clinica_id"=>$historia_clinica->id,
            ]
        );
        $fo_a_personales = FoAPersonal::updateOrCreate(
            [
               "ficha_ocupacional_id"=>$ficha_ocupacional->id, 
            ],
            [
                "estado_registro"=>"A",
                "observaciones_finales"=>$request->observaciones_finales,
            ]
        );
        
        $patologias = $request->patologias;

        foreach($patologias as $patologia){
            $hospital_patologia = HospitalPatologia::find($patologia['hospital_patologia_id']);
            
            $fo_personal_patologia = FoPersonalPatologia::firstOrCreate(
                [
                    "patologia_id"=>$hospital_patologia->patologia_id,
                    "fo_a_personal_id"=>$fo_a_personales->id,
                    "hospital_patologia_id"=>$hospital_patologia->id,
                ],
                [
                    "observaciones"=>$request->observaciones,

                ]
            );
        }
        $atencion_servicio = AtencionServicio::where('servicio_id',$request->servicio_id)->where('atencion_id',$request->atencion_id)->first();
        $atencion_servicio->fill([
            "estado_atencion"=>2,
            "hora_fin"=>date('H:i:s'),
        ])->save();

        return response()->json(["resp"=>"datos guardados"]);

    }
}
