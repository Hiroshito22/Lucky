<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteServicio extends Model
{
    protected $table = 'paquete_servicio';
    protected $fillable = array(
                            'paquete_id',
                            'clinica_servicio_id',
                            'estado_registro',

                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function paquete(){
        return $this->belongsTo(Paquete::class)->where('estado_registro','A');
    }
    public function clinica_servicio()
    {
        return $this->belongsTo(ClinicaServicio::class)->where('estado_registro','A');
    }
}
