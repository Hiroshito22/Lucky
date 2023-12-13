<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroEntrada extends Model
{
    use HasFactory;
    protected $table = 'registro_entrada';
    protected $fillable = array(
                            'fecha_entrada',
                            'proveedor_id',
                            'almacen_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }
    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor_id','id');
    }
}
