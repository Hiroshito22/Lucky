<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TransportistaVehiculo extends Model
{
    protected $table = 'transportista_vehiculo';
    protected $fillable = array(
                            'transportista_id',
                            'vehiculo_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function transportista(){
        return $this->belongsTo(Personal::class,'transportista_id','id');
    }
    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class);
    }
}
