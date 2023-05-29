<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedentesOftalmologia extends Model
{
    protected $table = 'antecedentes_oftalmologias';
    protected $fillable = array(
                            'clinica_servicio_id',
                            'conductor_id',
                            'correctores_id',
                            'tipo',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function clinica_servicio(){
        return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id','id');
    }

    public function conductor(){
        return $this->belongsTo(Conductor::class,'conductor_id','id');
    }

    public function correctores(){
        return $this->belongsTo(Correctores::class,'correctores_id','id');
    }

    public function antecedentes_oculares(){
        // return $this->hasMany(AntecedentesOculares::class,'id','antecedentes_oftalmologias_id');
        return $this->hasMany(AntecedentesOculares::class,'antecedentes_oftalmologias_id','id')->where('estado_registro', 'A');
    }

    public function antecedentes_sistemico(){
        return $this->hasMany(AntecedentesSistemico::class,'antecedentes_oftalmologias_id','id')->where('estado_registro', 'A');
    }
}
