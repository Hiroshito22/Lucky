<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BregmaPersonal extends Model
{
    protected $table = 'bregma_personal';
    protected $fillable = array(
        'bregma_area_id',
        'rol_id',
        'bregma_id',
        'user_rol_id',
        'persona_id',
        'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id');
    }
    public function bregma()
    {
        return $this->belongsTo(Bregma::class, 'bregma_id', 'id')->where('estado_registro', 'A');
    }
    public function user_rol()
    {
        return $this->belongsTo(UserRol::class, 'user_rol_id', 'id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
    public function bregma_area()
    {
        return $this->belongsTo(BregmaArea::class, 'bregma_area_id', 'id');
    }
}
