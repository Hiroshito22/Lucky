<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correctores extends Model
{
    protected $table = 'correctores';
    protected $fillable = array(
                            'respuesta',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function antecedentes_oftalmologia()
    {
        return $this->hasOne(AntecedentesOftalmologia::class);
    }
}
