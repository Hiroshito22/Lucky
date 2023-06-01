<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $fillable = array(
                            'producto_id',
                            'persona_id',
                            'modo_pago_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
    }
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    public function modo_pago(){
        return $this->belongsTo(ModoPago::class,'modo_pago_id','id');
    }
}
