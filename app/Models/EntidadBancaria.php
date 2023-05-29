<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadBancaria extends Model
{
    //
    protected $table = 'entidad_bancaria';
    protected $fillable = array(
                            'nombre',
                            'logo',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
