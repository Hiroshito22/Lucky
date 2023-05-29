<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $fillable = array(
                            'nombre',
                            'bregma_id',
                            'empresa_id',
                            'clinica_id',
                            'tipo_acceso',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function accesos_roles(){
        return $this->hasMany(AccesoRol::class,'rol_id','id');
    }
    public function accesos(){
        return $this->belongsToMany('App\Models\Acceso','acceso_rol')->wherePivot('estado_registro','A');
    }
    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id')->where('estado_registro','A');
    }
    public function acceso_rol(){
        return $this->hasOne(AccesoRol::class);
    }
}
