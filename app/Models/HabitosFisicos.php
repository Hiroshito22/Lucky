<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitosFisicos extends Model
{
    protected $table = 'habitos_fisicos';
    protected $fillable = array(
                            'ficha_ocupacional_id',
                            'frecuencia_id',
                            'deporte_id',
                            'tiempo',
                            'observaciones',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function deporte(){
        return $this->belongsTo(Deporte::class);
    }
    public function frecuencia(){
        return $this->belongsTo(Frecuencia::class);
    }
}
