<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBoleta extends Model
{
    use HasFactory;
    protected $table = 'tipo_boleta';
    protected $fillable = array(
                            'nombre',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
