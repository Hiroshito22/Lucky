<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Liquidacion extends Model
{
    protected $table = 'liquidacion';
    protected $fillable = array(
                            'total',
                            'subtotal',
                            'igv',
                            'empresa_id',
                            'hospital_id',
                            'persona_id',
                            'estado_registro',
                            'estado_pago',
                            'factura',
                            'observaciones',
                            'fecha_emision'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function getFacturaAttribute($value)
    {
        if ($value) {
            return url(Storage::url('public/facturas' . '/' . $value));
        }
        return $value;
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class)->where('estado_registro','A');
    }
    public function hospital(){
        return $this->belongsTo(Hospital::class)->where('estado_registro','A');
    }
    public function particular(){
        return $this->belongsTo('App\User','particular_id','id');
    }
    public function liquidacion_detalle(){
        return $this->hasMany(LiquidacionDetalle::class)->where('estado_registro','A');
    }
}
