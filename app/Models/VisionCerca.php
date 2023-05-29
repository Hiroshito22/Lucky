<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionCerca extends Model
{
    protected $table = 'vision_cerca';
    protected $fillable = array(
                            'ojo_derecho_id',
                            'ojo_izquierdo_id',
                            'binocular_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function correccion_no(){
        return $this->hasOne(CorreccionSi::class);
    }
    public function correccion_si(){
        return $this->hasOne(CorreccionNo::class);
    }
    public function medida_derecho(){
        return $this->belongsTo(MedidaCerca::class,'ojo_derecho_id','id');
    }
    public function medida_izquierdo(){
        return $this->belongsTo(MedidaCerca::class,'ojo_izquierdo_id','id');
    }
    public function binocular(){
        return $this->belongsTo(MedidaCerca::class,'binocular_id','id');
    }
}
