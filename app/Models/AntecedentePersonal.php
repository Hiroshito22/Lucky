<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedentePersonal extends Model
{
    protected $table = 'antecedente_personal';
    protected $fillable = array(
                            // 'clinica_servicio_id',
                            'trabajador_id',
                            'inmunizaciones',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    // public function clinica_servicio()
    // {
    //     return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id', 'id');
    // }

    public function triaje(){
        return $this->hasOne(Triaje::class);
    }
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class,'trabajador_id', 'id');
    }

    public function antecedentes()
    {
        return $this->hasMany(Antecedente::class);
    }

    public function clinica_patologia_personal()
    {
        return $this->hasMany(ClinicaPatologiaPersonal::class);
    }
}


