<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiempo extends Model
{
    protected $table = 'tiempo';
    protected $fillable = array(
                            'tipo_tiempo_id',
                            'cantidad',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function tipo_tiempo(){
        return $this->belongsTo(TipoTiempo::class,'tipo_tiempo_id','id');
    }
}
