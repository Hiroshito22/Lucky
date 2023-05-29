<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    protected $table = 'patologia';
    protected $fillable = array(
                            'tipo_patologia_id',
                            'nombre',
                            'hospital_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function tipo_patologias(){
        return $this->belongsTo(TipoPatologia::class,'tipo_patologia_id','id')->where('estado_registro','A');
    }

    public function hospitales(){
        return $this->belongsTo(Hospital::class,'hospital_id','id');
    }
    public function clinica_patologia(){
        return $this->hasMany(ClinicaPatologia::class);
    }
}
