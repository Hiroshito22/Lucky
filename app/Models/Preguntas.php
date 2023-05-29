<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    protected $table = 'preguntas';
    protected $fillable = array(
                            'clinica_servicio_id',
                            'evaluacion_psicopatologica_id',
                            'evaluacion_organica_id',
                            'evaluacion_emocional_id',
                            'sano_mentalmente_id',
                            'tipo_estres_id',
                            'test_somnolenda_id',
                            'test_fatiga_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function clinica_servicio(){
        return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id','id');
    }
    public function evaluaciones_psicopatologicas(){
        return $this->belongsTo(EvaluacionPsicopatologica::class,'evaluacion_psicopatologica_id','id');
    }
    public function evaluacion_organica(){
        return $this->belongsTo(EvaluacionOrganica::class,'evaluacion_organica_id','id');
    }
    public function evaluacion_emocional(){
        return $this->belongsTo(EvaluacionEmocional::class,'evaluacion_emocional_id','id');
    }
    public function sano_mentalmente(){
        return $this->belongsTo(SanoMentalmente::class,'sano_mentalmente_id','id');
    }
    public function tipo_estres(){
        return $this->belongsTo(TipoEstres::class,'tipo_estres_id','id');
    }
    public function test_somnolenda(){
        return $this->belongsTo(TestSomnolenda::class,'test_somnolenda_id','id');
    }
    public function test_fatiga(){
        return $this->belongsTo(TestFatiga::class,'test_fatiga_id','id');
    }
}
