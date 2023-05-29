<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekg extends Model
{
    protected $table = 'ekg';
    protected $fillable = array(
                            'datos_ekg_id',
                            //'preguntas_ekg_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    // public function clinica_servicio(){
    //     return $this->belongsTo(ClinicaServicio::class);
    // }
    public function datos_ekg(){
        return $this->hasOne(DatosEkg::class);
    }
    // public function preguntas_ekg(){
    //     return $this->hasOne(PreguntasEkg::class);
    // }
}
