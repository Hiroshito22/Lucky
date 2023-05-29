<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoRuta extends Model
{
    use HasFactory;
    protected $table = 'estado_ruta';
    protected $fillable = array(
        'nombre',
        'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
