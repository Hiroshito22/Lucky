<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionLejos extends Model
{
    protected $table = 'vision_lejos';
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
        return $this->belongsTo(MedidaLejos::class,'ojo_derecho_id','id');
    }
    public function medida_izquierdo(){
        return $this->belongsTo(MedidaLejos::class,'ojo_izquierdo_id','id');
    }
    public function binocular(){
        return $this->belongsTo(MedidaLejos::class,'binocular_id','id');
    }
}
