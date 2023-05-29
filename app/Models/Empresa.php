<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $fillable = array(
                            'ruc',
                            'razon_social',
                            // 'user_rol_id',
                            'responsable',
                            'nombre_comercial',
                            'latitud',
                            'longitud',
                            // 'tipo_emopresa_id',
                            'numero_documento',
                            'tipo_documento_id',
                            'distrito_id',
                            'direccion',
                            'ubicacion_mapa',
                            'aniversario',
                            'rubro_id',
                            'cantidad_trabajadores',
                            'años_actividad',
                            'logo',
                            // 'hospital_id',
                            'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function getLogoAttribute($value)
    {
        if ($value) {
            return url(Storage::url('public/empresa' . '/' . $value));
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
    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class);
    }
    public function atenciones(){
        return $this->hasMany(Atencion::class)->where('estado_registro','A')->where('estado_atencion',0);
    }
    public function contratos()
    {
        return $this->hasMany(Contrato::class)->where('estado_registro', 'A');
    }
    public function celulares(){
        return $this->hasMany(CelularInstitucion::class,'empresa_id','id');
    }
    public function correos(){
        return $this->hasMany(CorreoInstitucion::class,'empresa_id','id');
    }
    public function rubro(){
        return $this->hasMany(Rubro::class,'rubro_id','id');
    }
}
