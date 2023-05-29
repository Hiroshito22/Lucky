<?php

namespace App\Models;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicaPersonal extends Model
{
    use HasFactory;
    protected $table = 'clinica_personal';
    protected $fillable = array(
                            'clinica_area_id',
                            'rol_id',
                            'clinica_id',
                            'user_rol_id',
                            'persona_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id','id');
    }
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    public function user_rol()
    {
        return $this->belongsTo(UserRol::class, 'user_rol_id', 'id');
    }
    public function perfil()
    {
        return $this->belongsTo(UserRol::class, 'user_rol_id', 'id');
    }
    public function clinica_area()
    {
        return $this->belongsTo(ClinicaArea::class, 'clinica_area_id', 'id');
    }
}
