<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaPsicologicaOcupacional extends Model
{
    protected $table = 'ficha_psicologica_ocupacional';
    protected $fillable = array(
                            'historia_clinica_id',
                            'numero_ficha',
                            'fecha_emision',
                            'estado_registro',
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
    public function motivo_evaluacion(){
        return $this->hasMany(MotivoEvaluacion::class);
    }
    public function datos_ocupacionales(){
        return $this->hasMany(DatoOcupacional::class);
    }
    public function anteriores_empresas(){
        return $this->hasMany(AnteriorEmpresa::class);
    }
    public function observaciones_conductas(){
        return $this->hasMany(ObservacionConducta::class);
    }
    public function procesos_cognitivos(){
        return $this->hasOne(ProcesoCognitivo::class);
    }

}
