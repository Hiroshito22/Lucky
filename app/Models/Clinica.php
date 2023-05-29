<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Clinica extends Model
{
    protected $table = 'clinica';
    protected $fillable = array(
        'tipo_documento_id',
        'distrito_id',
        'numero_documento',
        'razon_social',
        'direccion',
        'estado_pago',
        'latitud',
        'longitud',
        'estado_registro',
        //'responsable',
        'nombre_comercial',
        'logo',
        // 'hospital_id'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function getLogoAttribute($value)
    {
        if ($value) {
            return url(Storage::url('public/clinica' . '/' . $value));
        }
        return $value;
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id')->where('estado_registro', 'A');
    }
    public function user_rol()
    {
        return $this->belongsTo(UserRol::class, 'user_rol_id', 'id')->where('estado_registro', 'A');
    }
    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id', 'id')->where('estado_registro', 'A');
    }
    public function distrito()
    {
        return $this->belongsTo(Distritos::class, 'distrito_id', 'id');
    }
    public function mis_paquetes()
    {
        return $this->hasMany(EmpresaPaquete::class)->where('estado_registro', 'A');
    }
    public function contrato()
    {
        return $this->hasMany(Contrato::class, 'clinica_id', 'id')->where('estado_registro', 'A');
    }
    public function superareas()
    {
        return $this->hasMany(Superarea::class)->where('estado_registro', 'A');
    }
    public function bregma()
    {
        return $this->belongsTo(Bregma::class, 'bregma_id', 'id');
    }
    public function clinica_local()
    {
        return $this->hasMany(ClinicaLocal::class)->where('estado_registro', 'A');
    }
    public function celulares()
    {
        return $this->hasMany(CelularInstitucion::class, 'clinica_id', 'id');
    }
    public function correos()
    {
        return $this->hasMany(CorreoInstitucion::class, 'clinica_id', 'id');
    }
    public function detracciones()
    {
        return $this->hasMany(Detraccion::class, 'clinica_id', 'id');
    }
    public function entidad_pagos()
    {
        return $this->hasMany(EntidadPago::class, 'clinica_id', 'id');
    }

    public function clinica_servicio()
    {
        return $this->hasMany(ClinicaServicio::class);
    }
    public function clinica_paquete()
    {
        return $this->hasMany(ClinicaPaquete::class);
    }
}
