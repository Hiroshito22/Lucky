<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClinicaContacto extends Model
{
    protected $table = 'clinica_contacto';
    protected $fillable = array(
                            'persona_id',
                            'clinica_id',
                            //'users_rol_id',
                            'estado_registro',
                            );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    public function clinica(){
        return $this->belongsTo(Clinica::class,'clinica_id','id')->where('estado_registro','A');
    }
    /*public function users_rol(){
        return $this->belongsTo(UserRol::class,'users_rol_id','id');
    }*/
}
