<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradoInstruccion extends Model
{
    protected $table = 'grado_instruccion';
    protected $fillable = array(
                            'nombre',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
