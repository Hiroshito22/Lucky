<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionDetalle extends Model
{
    protected $table = 'liquidacion_detalle';
    protected $fillable = array(
                            'liquidacion_id',
                            'atencion_id',
                            'subtotal',
                            'total',
                            'igv',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function liquidacion(){
        return $this->belongsTo(Liquidacion::class)->where('estado_registro','A');
    }
    public function atencion(){
        return $this->belongsTo(Atencion::class)->where('estado_registro','A');
    }
}
