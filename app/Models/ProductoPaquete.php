<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoPaquete extends Model
{
    protected $table = 'producto_paquete';
    protected $fillable = array(
                            'producto_id',
                            'paquete_id',
                            "estado_registro"
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function paquete(){
        return $this->belongsTo(Paquete::class);
    }
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
