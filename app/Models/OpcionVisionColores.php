<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionVisionColores extends Model
{
    protected $table = 'opcion_vision_colores';
    protected $fillable = array(
                            'nombre',
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
