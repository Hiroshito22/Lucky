<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TipoCliente extends Model
{
    protected $table = 'tipo_cliente';
    protected $fillable = array(
                            "nombre",
                            "estado_registro",
                            );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','update_at','delete_at'
    ];
}
