<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroAusentismo extends Model
{
    protected $table = 'registro_ausentismo';
    protected $fillable = array(
                            'tipo_antecedente',
                            'asociado_trabajo',
                            'desripcion',
                            'fecha_inicio',
                            'dias_incapacidad',
                            'ficha_final',
                            'menoscabo'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
