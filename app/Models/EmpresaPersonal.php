<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaPersonal extends Model
{
    protected $table = 'empresa_personal';
    protected $fillable = array(
            'empresa_area_id',
            'rol_id',
            'empresa_id',
            'user_rol_id',
            'persona_id',
            'estado_reclutamiento',
            'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function empresa_area()
    {
        return $this->belongsTo(EmpresaArea::class, 'empresa_area_id', 'id');
    }
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id')->where('estado_registro', 'A');
    }
    public function user_rol()
    {
        return $this->belongsTo(UserRol::class, 'user_rol_id', 'id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }

    public function hojas_ruta(){
        return $this->belongsTo(HojaRuta::class);
    }
}
