<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ritmo extends Model
{
    protected $table = 'ritmo';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
