<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'paquete';
    protected $fillable = array(
                            'nombre',
                            'precio',
                            'clinica_id',
                            'estado_delivery',
                            'estado_registro',

                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function clinica(){
        return $this->belongsTo(Clinica::class)->where('estado_registro','A');
    }
    public function paquete_servicio()
    {
        return $this->hasOne(PaqueteServicio::class);
    }
    public function servicios()
    {
        return $this->belongsToMany(ClinicaServicio::class,'paquete_servicio')->wherePivot('estado_registro','A');
    }
}
