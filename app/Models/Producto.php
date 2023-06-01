<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = array(
                            'descripcion',
                            'foto',
                            'marca_id',
                            'unidad_medida_id',
                            'empresa_id',
                            'cantidad',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function marca(){
        return $this->belongsTo(Marca::class,'marca_id','id');
    }
    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_medida_id','id');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
}
