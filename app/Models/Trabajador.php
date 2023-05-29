<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajador';
    protected $fillable = array(
                            'estado_trabajador',
                            'empresa_id',
                            'sucursal_id',
                            'subarea_id',
                            'persona_id',
                            'user_rol_id',
                            'cargo_id',
                            'puesto',
                            'tipo_trabajador_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class,'sucursal_id','id');
    }
    public function subarea(){
        return $this->belongsTo(Subarea::class);
    }
    public function persona(){
        return $this->belongsTo(Persona::class);
    }
    public function user_rol(){
        return $this->belongsTo(UserRol::class);
    }
    public function tipo_trabajador(){
        return $this->belongsTo(TipoTrabajador::class,'tipo_trabajador_id','id');
    }
    public function cargo(){
        return $this->belongsTo(Cargo::class,'cargo_id','id');
    }
    public function antecedentepersonales()
    {
        return $this->hasMany(AntecedentePersonal::class);
    }
}
