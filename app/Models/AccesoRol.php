<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccesoRol extends Model
{
    protected $table = 'acceso_rol';
    protected $fillable = array(
                            'acceso_id',
                            'rol_id',
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function acceso(){
        return $this->belongsTo(Acceso::class,'acceso_id','id');
    }
    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id','id');
    }
}
