<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntasEkg extends Model
{
    protected $table = 'preguntas_ekg';
    protected $fillable = array(
                            'descripcion',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    // public function clinica_servicio(){
    //     return $this->belongsTo(ClinicaServicio::class);
    // }
    // public function ekg(){
    //     return $this->hasOne(Ekg::class);
    // }
}
