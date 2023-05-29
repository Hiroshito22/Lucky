<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgudezaVisual extends Model
{
    protected $table = 'agudeza_visual';
    protected $fillable = array(
                            'clinica_servicio_id',
                            'correccion_si_id',
                            'correccion_no_id',
                            'opcion_vision_colores_id',
                            'opcion_reflejos_pupilares_id',
                            'opcion_enfermedad_ocular_id',
                            'tonometria_id',
                            'examen_externo_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function clinica_servicio(){
        return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id','id');
    }
    public function correccion_si(){
        return $this->belongsTo(CorreccionSi::class,'correccion_si_id','id');
    }
    public function correccion_no(){
        return $this->belongsTo(CorreccionNo::class,'correccion_no_id','id');
    }
    public function opcion_vision_colores(){
        return $this->belongsTo(OpcionVisionColores::class,'opcion_vision_colores_id','id');
    }
    public function opcion_reflejos_pupilares(){
        return $this->belongsTo(OpcionReflejosPupilares::class,'opcion_reflejos_pupilares_id','id');
    }
    public function opcion_enfermedad_ocular(){
        return $this->belongsTo(OpcionEnfermedadOcular::class,'opcion_enfermedad_ocular_id','id');
    }
    public function examen_externo(){
        return $this->belongsTo(ExamenExterno::class,'examen_externo_id','id');
    }
    public function tonometria(){
        return $this->belongsTo(Tonometria::class,'tonometria_id','id');
    }
}
