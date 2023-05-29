<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnfermedadEspecifica extends Model
{
    protected $table = 'enfermedad_especifica';
    protected $fillable = array(
                            'codigo',
                            'enfermedad_especifica',
                            'enfermedad_general_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
