<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;
    protected $table = 'boleta';
    protected $fillable = array(
                            'cantidad',
                            'producto_id',
                            'persona_id',
                            'tipo_boleta_id',
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
    public function tipo_boleta(){
        return $this->belongsTo(TipoBoleta::class,'tipo_boleta_id','id');
    }
}
