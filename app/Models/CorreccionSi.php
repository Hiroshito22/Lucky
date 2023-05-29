<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorreccionSi extends Model
{
    protected $table = 'correccion_si';
    protected $fillable = array(
                            'vision_lejos_id',
                            'vision_cerca_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function agudeza_visual(){
        return $this->hasOne(AgudezaVisual::class);
    }
    public function vision_lejos(){
        return $this->belongsTo(VisionLejos::class,'vision_lejos_id','id');
    }
    public function vision_cerca(){
        return $this->belongsTo(VisionCerca::class,'vision_cerca_id','id');
    }
}
