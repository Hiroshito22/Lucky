<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitosNocivosDetalles extends Model
{
    protected $table = 'habitos_nocivos_detalles';
    protected $fillable = array(
                            'habito_id',
                            'habito_nocivo_id',
                            'frecuencia_id',
                            'tiempo',
                            'tipo',
                            'unidad',
                            'cantidad',
                            'observaciones',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function habito_nocivo(){
        return $this->belongsTo(HabitoNocivo::class);
    }
    public function frecuencia(){
        return $this->belongsTo(frecuencia::class);
    }
}
