<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacen';
    protected $fillable = array(
                            'descripcion',
                            'producto_id',
                            'empresa_id',
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
}
