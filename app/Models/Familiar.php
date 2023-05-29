<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    protected $table = 'familiar';
    protected $fillable = array(
                            'antecedente_familiar_id',
                            'tipo_familiar_id',
                            // 'nombre',
                            // 'apellido_paterno',
                            // 'apellido_materno',
                            'hospital_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function tipo_familiares()
    {
        return $this->belongsTo(TipoFamiliar::class,'tipo_familiar_id', 'id');
    }
    public function clinicas_patologias_familiares()
    {
        return $this->hasMany(ClinicaPatologiaFamiliar::class);
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class)->where('estado_registro','A');
    }

    public function antecedente_familiar()
    {
        return $this->belongsTo(AntecedenteFamiliar::class,'antecedente_familiar_id','id');
    }

    public function clinica_patologia_familiar()
    {
        return $this->hasMany(ClinicaPatologiaFamiliar::class);
    }

}
