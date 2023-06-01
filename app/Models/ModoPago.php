<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModoPago extends Model
{
    use HasFactory;
    protected $table = 'modo_pago';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
