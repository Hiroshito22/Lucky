<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bregma extends Model
{
    protected $table = 'bregma';
    protected $fillable = array(
                            'tipo_documento_id',
                            'distrito_id',
                            //'user_rol_id',
                            'numero_documento',
                            'razon_social',
                            'direccion',
                            'estado_pago',
                            'latitud',
                            'longitud',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function contrato()
    {
        return $this->hasMany(Contrato::class,'bregma_id','id')->where('estado_registro','A');
    }
    public function superareas()
    {
        return $this->hasMany(Superarea::class)->where('estado_registro','A');
    }
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class,'tipo_documento_id','id');
    }
    public function distrito(){
        return $this->belongsTo(Distritos::class,'distrito_id','id');
    }
    public function celulares(){
        return $this->hasMany(CelularInstitucion::class,'bregma_id','id');
    }
    public function correos(){
        return $this->hasMany(CorreoInstitucion::class,'bregma_id','id');
    }
    public function detracciones(){
        return $this->hasMany(Detraccion::class,'bregma_id','id');
    }
    public function entidad_pagos(){
        return $this->hasMany(EntidadPago::class,'bregma_id','id');
    }
}
