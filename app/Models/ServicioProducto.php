<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioProducto extends Model
{
    protected $table = 'servicio_producto';
    protected $fillable = array(
                            'servicio_hospital_id',
                            'producto_id',
                            "estado_registro"
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function servicio_hospital(){
        return $this->belongsTo(ServicioHospital::class);
    }
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
