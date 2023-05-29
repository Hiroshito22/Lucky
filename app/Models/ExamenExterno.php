<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenExterno extends Model
{
    protected $table = 'examen_externo';
    protected $fillable = array(
                            'opcion_ojo_derecho_id',
                            'opcion_ojo_izquierdo_id',
                            'examen_clinico',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function agudeza_visual(){
        return $this->hasOne(AgudezaVisual::class);
    }
    public function opcion_ojo_izquierdo(){
        return $this->belongsTo(OpcionOjoIzquierdo::class,'opcion_ojo_izquierdo_id','id');
    }
    public function opcion_ojo_derecho(){
        return $this->belongsTo(OpcionOjoDerecho::class,'opcion_ojo_derecho_id','id');
    }
}
