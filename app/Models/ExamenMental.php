<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenMental extends Model
{
    protected $table = 'examen_mental';
    protected $fillable = array(
                            'clinica_servicio_id',
                            'presentacion_id',
                            'postura_id',
                            'ritmo_id',
                            'tono_id',
                            'articulacion_id',
                            'tiempo_id',
                            'espacio_id',
                            'persona_mental_id',
                            'coordinacion_visomotriz_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function clinica_servicio(){
        return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id','id');
    }
    public function presentacion(){
        return $this->belongsTo(Presentacion::class,'presentacion_id','id');
    }
    public function postura(){
        return $this->belongsTo(Postura::class,'postura_id','id');
    }
    public function ritmo(){
        return $this->belongsTo(Ritmo::class,'ritmo_id','id');
    }
    public function tono(){
        return $this->belongsTo(Tono::class,'tono_id','id');
    }
    public function articulacion(){
        return $this->belongsTo(Articulacion::class,'articulacion_id','id');
    }
    public function tiempo(){
        return $this->belongsTo(Tiempo::class,'tiempo_id','id');
    }
    public function espacio(){
        return $this->belongsTo(Espacio::class,'espacio_id','id');
    }
    public function persona_mental(){
        return $this->belongsTo(PersonaMental::class,'persona_mental_id','id');
    }
    public function coordinacion_visomotriz(){
        return $this->belongsTo(CoordinacionVisomotriz::class,'coordinacion_visomotriz_id','id');
    }
}
