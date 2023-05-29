<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenSegmentado extends Model
{
    protected $table = 'examen_segmentado';
    protected $fillable = array(
                            'ojo_derecho_id',
                            'ojo_izquierdo_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function ojo_derecho(){
        return $this->belongsTo(Segmento::class, 'ojo_derecho_id', 'id');
    }
    public function ojo_izquierdo(){
        return $this->belongsTo(Segmento::class, 'ojo_izquierdo_id', 'id');
    }
    public function test()
    {
        return $this->hasOne(Test::class);
    }
}
