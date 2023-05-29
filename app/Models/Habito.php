<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habito extends Model
{
    protected $table = 'habito';
    protected $fillable = array(
                            'tipo_habito_id',
                            'habito_nocivo_id',
                            'frecuencia_id',
                            'frecuencia',
                            'tiempo',
                            'tipo',
                            'cantidad',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function tipo_habito_id(){
        return $this->belongsTo(TipoHabito::class,'tipo_habito_id','id');
    }
    public function habito_nocivo(){
        return $this->belongsTo(HabitoNocivo::class,'habito_nocivo_id','id');
    }
    public function frecuencia(){
        return $this->belongsTo(Frecuencia::class,'frecuencia_id','id');
    }
}
