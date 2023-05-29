<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postura extends Model
{
    protected $table = 'postura';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
