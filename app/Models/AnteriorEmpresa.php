<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnteriorEmpresa extends Model
{
    protected $table = 'anteriores_empresas';
    protected $fillable = array(
                            'ficha_psicologica_ocupacional_id',
                            'fecha',
                            'nombre_empresa',
                            'actividad_empresa',
                            'puesto',
                            'causa_retiro',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
