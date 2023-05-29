<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tonometria extends Model
{
    protected $table = 'tonometria';
    protected $fillable = array(
                            'ojo_derecho',
                            'ojo_izquierdo',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function agudeza_visual(){
        return $this->hasOne(AgudezaVisual::class);
    }
}
