<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioHospital extends Model
{
    protected $table = 'servicio_hospital';
    protected $fillable = array(
                            'precio',
                            'servicio_id',
                            'hospital_id',
                            'estado',
                            'estado_delivery',
                            "estado_registro",
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function servicio()
    {
        return $this->belongsTo(Servicio::class)->where('estado_registro','A');
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class)->where('estado_registro','A');
    }
}
