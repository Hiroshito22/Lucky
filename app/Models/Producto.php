<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = array(
                            'nom_producto',
                            'descripcion',
                            //'foto',
                            'cantidad',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function producto_detalle(){
        return $this->belongsTo(ProductoDetalle::class,'id');
    }
}
