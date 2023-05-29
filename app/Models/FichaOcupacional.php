<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaOcupacional extends Model
{
    protected $table = 'ficha_ocupacional';
    protected $fillable = array(
                            'historia_clinica_id',
                            'tipo_evaluacion_id',
                            'lugar_examen_departamento',
                            'lugar_examen_provincia',
                            'lugar_examen_distrito',
                            'fecha_emision',
                            'puesto_evaluacion',
                            'inmunizaciones',
                            'estado_atencion',
                            'estado_registro',
                            'atencion_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }
    public function historia_clinica(){
        return $this->belongsTo(HistoriaClinica::class);
    }
    public function ficha_trabajador(){
        return $this->hasOne(FichaTrabajador::class);
    }
    public function ficha_empresa(){
        return $this->hasOne(FichaEmpresa::class);
    }
    // public function antecedente_familiar(){
    //     return $this->hasMany(AntecedenteFamiliar::class);
    // }
    public function antecedente_personal(){
        return $this->hasMany(AntecedentePersonal::class);
    }
    public function habitos(){
        return $this->hasMany(Habito::class);
    }
    // public function evaluacion_medica(){
    //     return $this->hasMany(EvaluacionMedica::class);
    // }
    public function signos_vitales(){
        return $this->hasOne(SignosVitales::class);
    }

}
