<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoEvaluacion extends Model
{
    protected $table = 'motivo_evaluacion';
    protected $fillable = array(
                            //'ficha_psicologica_ocupacional_id',
                            //'motivo_evaluacion',
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function DatoOcupacional(){
        return $this->hasOne(DatoOcupacional::class);
    }
}
