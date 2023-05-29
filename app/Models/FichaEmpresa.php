<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaEmpresa extends Model
{
    protected $table = 'ficha_empresa';
    protected $fillable = array(
                            'ficha_ocupacional_id',
                            'ficha_psicologica_ocupacional_id',
                            'empresa_id',
                            'razon_social',
                            'actividad_economica',
                            'lugar_trabajo',
                            'distrito_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
