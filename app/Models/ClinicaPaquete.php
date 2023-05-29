<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicaPaquete extends Model
{
    protected $table = 'clinica_paquete';
    protected $fillable = array(
                'clinica_servicio_id',
                'clinica_id',
                'icono',
                'nombre',
                // 'parent_id',
                'precio',
                'estado_registro',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class,'clinica_id', 'id');
    }
    /*public function servicios()
    {
        return $this->belongsToMany(ClinicaServicio::class);
    }*/

    // public function servicios()
    // {
    //     //return $this->belongsToMany(ClinicaServicio::class, 'clinica_paquete_servicio');
    //     return $this->belongsToMany(ClinicaServicio::class, 'clinica_paquete_servicio', 'clinica_paquete_id', 'clinica_servicio_id', 'clinica_id');
    // }

    public function clinica_servicio()
    {
        return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id','id');
    }
    // public function perfil()
    // {
    //     return $this->hasMany(Perfil::class);
    // }

    //cambio de nombre a la funcion
    public function perfiles()
    {
        return $this->hasMany(Perfil::class);
    }

    public function perfil_tipos()
    {
        return $this->hasManyThrough(PerfilTipo::class, Perfil::class)->whereIn('tipo_perfil_id',[2, 3]);
    }
}
