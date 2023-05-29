<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
    protected $table = 'atencion';
    protected $fillable = array(
                            'trabajador_id',
                            'empresa_id',
                            'fecha_emision',
                            'fecha_atencion',
                            'estado_atencion',
                            'estado_registro',
                            'tipo_atencion',
                            'persona_id',
                            'tipo_evaluacion_id',
                            'paquete_id',
                            'total',
                            'subtotal',
                            'igv',
                            'hospital_id',
                            'sucursal_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function trabajador(){
        return $this->belongsTo(Trabajador::class,'trabajador_id','id')->where('estado_registro','A');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id')->where('estado_registro','A');
    }
    public function atencion_servicio(){
        return $this->hasMany(AtencionServicio::class)->where('estado_registro','A');
    }
    public function tipo_evaluacion(){
        return $this->belongsTo(TipoEvaluacion::class,'tipo_evaluacion_id','id')->where('estado_registro','A');
    }
    public function paquete(){
        return $this->belongsTo(Paquete::class,)->where('estado_registro','A');
    }
    
    
    
}
