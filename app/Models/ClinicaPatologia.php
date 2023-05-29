<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicaPatologia extends Model
{
    protected $table = 'clinica_patologia';
    protected $fillable = array(
                'patologia_id',
                'clinica_id',
                'activo',
                'estado_registro',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
    // public function clinicas_patologias_familiares()
    // {
    //     return $this->hasMany(ClinicaPatologiaFamiliar::class);
    // }

    // public function patologias()
    // {
    //     return $this->belongsTo(Patologia::class,'patologia_id', 'id');
    // }

    // public function clinicas()
    // {
    //     return $this->belongsTo(Clinica::class,'clinica_id', 'id');
    // }

    // public function clinica_patologia_personal()
    // {
    //     return $this->hasMany(ClinicaPatologiaPersonal::class);
    // }

    // public function clinica_patologia_familiar()
    // {
    //     return $this->hasMany(ClinicaPatologiaFamiliar::class);
    // }

    // public function antecedentes_oculares()
    // {
    //     return $this->hasMany(AntecedentesOculares::class);
    // }
}
