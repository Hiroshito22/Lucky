<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionOjoIzquierdo extends Model
{
    protected $table = 'opcion_ojo_izquierdo';
    protected $fillable = array(
                            'medida',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function examen_externo(){
        return $this->hasOne(ExamenExterno::class);
    }
}
