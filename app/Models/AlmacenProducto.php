<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenProducto extends Model
{
    use HasFactory;
    protected $table = 'almacen_producto';
    protected $fillable = array(
                            'fecha_entrada',
                            'fecha_salida',
                            'producto_id',
                            'almacen_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
