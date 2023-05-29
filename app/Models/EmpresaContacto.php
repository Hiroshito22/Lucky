<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaContacto extends Model
{
    protected $table = 'empresa_contacto';
    protected $fillable = array(
                            'persona_id',
                            'empresa_id',
                            'user_rol_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }
    public function personas(){
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
    public function empresas(){
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }
    public function users_roles(){
        return $this->belongsTo(UserRol::class, 'user_rol_id', 'id');
    }
}
