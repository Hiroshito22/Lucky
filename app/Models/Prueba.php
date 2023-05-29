<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $table = 'pruebas';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function pruebas_psicologicas(){
        return $this->hasMany(PruebaPsicologica::class);
    }
}
