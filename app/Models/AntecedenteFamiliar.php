<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteFamiliar extends Model
{
    protected $table = 'antecedente_familiar';
    protected $fillable = array(
                            // 'servicio_clinica_id',
                            // 'triaje',
                            'numero_hijos_vivos',
                            'numero_hijos_fallecidos',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function clinicas_patologias_familiares(){
        return $this->hasMany(ClinicaPatologiaFamiliar::class);
    }
    // public function servicios_clinicas(){
    //     return $this->belongsTo(ServicioClinica::class,'servicio_clinica_id','id');
    // }
    public function triaje(){
        return $this->hasOne(Triaje::class);
    }
    public function familiar(){
        return $this->hasMany(Familiar::class);
    }
}
