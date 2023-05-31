<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = array(
                            'tipo_producto_id',
                            'nombre',
                            'categoria',
                            'proveedor',
                            'cantidad',
                            'precio',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function tipo_producto(){
        return $this->belongsTo(TipoProducto::class,'tipo_producto_id','id');
    }
}
