<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicaPaqueteServicio extends Model
{
    protected $table = 'clinica_paquete_servicio';
    protected $fillable = array(
                'clinica_paquete_id',
                'clinica_servicio_id',
                'clinica_id',
                'estado_registro',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
    public function clinica_paquete()
    {
        return $this->belongsTo(ClinicaPaquete::class, 'clinica_paquete_id', 'id');
    }

    public function clinica_servicio()
    {
        return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id', 'id');
    }

    public function clinica()
    {
        return $this->belongsTo(Clinica::class,'clinica_id', 'id');
    }

}
