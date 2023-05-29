<?php

namespace App\Models;

use App\Model\ServicioClinica;
use Illuminate\Database\Eloquent\Model;

class SignosVitales extends Model
{
    protected $table = 'signos_vitales';
    protected $fillable = array(
                            'ficha_ocupacional_id',
                            // 'servicio_clinica_id',
                            'frec_cardiaca',
                            'frec_respiratoria',
                            'p_sistolica',
                            'p_diastolica',
                            'p_media',
                            'saturacion',
                            'temperatura',
                            'observaciones',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    // public function servicios_clinica(){
    //     return $this->belongsTo(ServicioClinica::class,'servicio_clinica_id','id')->where('estado_registro','A');
    // }
    public function triaje(){
        return $this->hasOne(Triaje::class);
    }
}
