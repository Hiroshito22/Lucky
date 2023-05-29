<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculo';
    protected $fillable = array(
                            'placa',
                            'particular',
                            'tipo_vehiculo_id',
                            'hospital_id',
                            'estado_ocupado',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function tipo_vehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class)->where('estado_registro','A');
    }
    public function hospial()
    {
        return $this->belongsTo(Hospital::class)->where('estado_registro','A');
    }
}
