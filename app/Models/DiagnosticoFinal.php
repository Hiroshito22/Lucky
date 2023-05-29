<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticoFinal extends Model
{
    protected $table = 'diagnostico_final';
    protected $fillable = array(
                            'clinica_servicio_id',
                            'area_cognitiva_id',
                            'area_emocional_id',
                            'recomendaciones_id',
                            'resultado_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function clinica_servicio(){
        return $this->belongsTo(ClinicaServicio::class, 'clinica_servicio_id', 'id');
    }
    public function area_cognitiva(){
        return $this->belongsTo(AreaCognitiva::class, 'area_cognitiva_id', 'id');
    }
    public function area_emocional(){
        return $this->belongsTo(AreaEmocional::class, 'area_emocional_id', 'id');
    }
    public function recomendaciones(){
        return $this->belongsTo(Recomendaciones::class, 'recomendaciones_id', 'id');
    }
    public function resultado(){
        return $this->belongsTo(Resultado::class, 'resultado_id', 'id');
    }
}
