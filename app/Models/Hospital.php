<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Hospital extends Model
{
    protected $table = 'hospital';
    protected $fillable = array(
                            'tipo_documento_id',
                            'numero_documento',
                            'razon_social',
                            'logo',
                            'direccion',
                            'distrito_id',
                            'estado_pago',
                            'latitud',
                            'longitud',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function getLogoAttribute($value)
    {
        if ($value) {
            return url(Storage::url('public/hospital' . '/' . $value));
        }
        return $value;
    }
    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }
    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }
    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
    public function trabajadores()
    {
        return $this->hasManyThrough(Trabajador::class,Empresa::class,'hospital_id','empresa_id');
    }
}
