<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoDetalle extends Model
{
    use HasFactory;
    protected $table = 'producto_detalle';
    protected $fillable = array(
                            'codigo',
                            'producto_id',
                            'marca_id',
                            'empresa_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
    public function marca(){
        return $this->belongsTo(Marca::class,'marca_id','id');
    }
}

