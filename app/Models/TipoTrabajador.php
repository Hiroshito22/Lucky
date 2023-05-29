<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTrabajador extends Model
{
    protected $table = 'tipo_trabajador';
    protected $fillable = array(
                            'descripcion',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
