<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteFamiliarDetalle extends Model
{
    protected $table = 'antecedente_familiar_detalle';
    protected $fillable = array(
                            'antecedente_familiar_id',
                            'patologico_id',
                            'comentario',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function patologico(){
        return $this->belongsTo(Patologico::class);
    }
    public function antecedente_familiar(){
        return $this->belongsTo(AntecedenteFamiliar::class);
    }
}
