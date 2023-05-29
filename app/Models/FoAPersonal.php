<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoAPersonal extends Model
{
    protected $table = 'fo_a_personal';
    protected $fillable = array(
                            'observaciones_finales',
                            'estado_registro',
                            'ficha_ocupacional_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
