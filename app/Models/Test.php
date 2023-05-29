<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    protected $fillable = array(
                            'clinica_servicio_id',
                            'vision_colores_id',
                            'reconoce_colores',
                            'dificultad_color',
                            'estereopsis_id',
                            'examen_segmentado_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function clinica_servicio(){
        return $this->belongsTo(ClinicaServicio::class, 'clinica_servicio_id', 'id');
    }
    public function vision_colores(){
        return $this->belongsTo(VisionColores::class, 'vision_colores_id', 'id');
    }
    public function estereopsis(){
        return $this->belongsTo(Estereopsis::class, 'estereopsis_id', 'id');
    }
    public function examen_segmentado(){
        return $this->belongsTo(ExamenSegmentado::class, 'examen_segmentado_id', 'id');
    }
}

