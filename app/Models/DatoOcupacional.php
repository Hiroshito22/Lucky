<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatoOcupacional extends Model
{
    protected $table = 'datos_ocupacionales';
    protected $fillable = array(
                            //'ficha_psicologica_ocupacional_id',
                            //'empresa_id',
                            //'nombre_empresa',
                            //'actividad_empresa',
                            //'area_trabajo',
                            //'tiempo_laborando',
                            //'puesto',
                            //'principales_riesgos_id',
                            //'medidas_seguridad_id',
                            //'clinica_servicio_id',
                            'motivo_evaluacion_id',
                            'principales_riesgos_id',
                            'medidas_seguridad_id',
                            'historia_familiar_id',
                            'accidentes_enfermedades_id',
                            'habitos_id',
                            'otras_observaciones_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    /*public function clinica_servicio(){
        return $this->belongsTo(ClinicaServicio::class);
    }*/
    public function motivo_evaluacion(){
        return $this->belongsTo(MotivoEvaluacion::class,'motivo_evaluacion_id','id');
    }
    public function principales_riesgos(){
        return $this->belongsTo(PrincipalRiesgo::class,'principales_riesgos_id', 'id');
    }
    public function medidas_seguridad(){
        return $this->belongsTo(MedidaSeguridad::class,'medidas_seguridad_id', 'id');
    }
    public function historia_familiar(){
        return $this->belongsTo(HistoriaFamiliar::class,'historia_familiar_id', 'id');
    }
    public function accidentes_enfermedades(){
        return $this->belongsTo(AccidentesEnfermedades::class,'accidentes_enfermedades_id', 'id');
    }
    public function habitos(){
        return $this->belongsTo(Habitos::class,'habitos_id', 'id');
    }
    public function otras_observaciones(){
        return $this->belongsTo(OtrasObservaciones::class,'otras_observaciones_id', 'id');
    }
    public function psicologia(){
        return $this->hasOne(Psicologia::class);
    }
}
