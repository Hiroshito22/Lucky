<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedidaLejos extends Model
{
    protected $table = 'medida_lejos';
    protected $fillable = array(
                            'medida',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function vision_cerca(){
        return $this->hasOne(VisionCerca::class);
    }
}
