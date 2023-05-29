<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitoDeporte extends Model
{
    protected $table = 'habito_deporte';
    protected $fillable = array(
                            'habito_nocivo_id',
                            'frecuencia_id',
                            'deporte_id',
                            'tiempo_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function frecuencia(){
        return $this->belongsTo(Frecuencia::class,'frecuencia_id','id');
    }
    public function deporte(){
        return $this->belongsTo(Deporte::class,'frecuencia_id','id');
    }
    public function tiempo(){
        return $this->belongsTo(Tiempo::class,'tiempo_id','id');
    }
    public function habito_nocivo(){
        return $this->belongsTo(HabitoNocivo::class,'habito_nocivo_id','id');
    }
}
