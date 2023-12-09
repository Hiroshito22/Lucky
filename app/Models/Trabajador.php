<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;
    protected $table = 'trabajador';
    protected $fillable = array(
                            'persona_id',
                            //'direccion_legal',
                            'rol_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id','id');
    }
}
