<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObservacionConducta extends Model
{
    protected $table = 'observacion_conducta';
    protected $fillable = array(
                            'ficha_psicologica_ocupacional_id',
                            'presentacion_id',
                            'postura_id',
                            'ritmo_id',
                            'tono_id',
                            'articulacion_id',
                            'tiempo_id',
                            'espacio_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function presentacion(){
        return $this->belongsTo(Presentacion::class);
    }
    public function postura(){
        return $this->belongsTo(Postura::class);
    }
    public function ritmo(){
        return $this->belongsTo(Ritmo::class);
    }
    public function tono(){
        return $this->belongsTo(Tono::class);
    }
    public function articulacion(){
        return $this->belongsTo(Articulacion::class);
    }
    public function tiempo(){
        return $this->belongsTo(Tiempo::class);
    }
    public function espacio(){
        return $this->belongsTo(Espacio::class);
    }
}
