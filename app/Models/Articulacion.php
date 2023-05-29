<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulacion extends Model
{
    protected $table = 'articulacion';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
