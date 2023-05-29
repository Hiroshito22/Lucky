<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psicologia extends Model
{ 
    protected $table = 'psicologia';
    protected $fillable = array(
                            'datos_ocupacionales_id',
                            'examen_mental_id',
                            'proceso_cognitivo_id',
                            'preguntas_id',
                            'diagnostico_final',

                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function datos_ocupacionales(){
        return $this->belongsTo(DatoOcupacional::class,'datos_ocupacionales_id','id');
    }

    public function examen_mental(){

        return $this->belongsTo(ExamenMental::class,'examen_mental_id','id');
    }
    public function experiencia_laboral(){
        return $this->hasMany(ExperienciaLaboral::class);
    }
    public function proceso_cognoscitivo(){

        return $this->belongsTo(ProcesoCognoscitivo::class,'datos_ocupacionales_id','id');
    }
    public function pruebas_psicologicas(){
        return $this->hasMany(PruebaPsicologica::class);
    }
    public function preguntas(){
        return $this->belongsTo(Preguntas::class,'datos_ocupacionales_id','id');
    }
    public function diagnostico_final(){
        return $this->hasMany(DiagnosticoFinal::class);
    }
}
