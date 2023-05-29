<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesoTalla extends Model
{
    protected $table = 'peso_talla';
    protected $fillable = array(
                            'triaje_id',
                            'peso',
                            'talla',
                            'cintura',
                            'cadera',
                            'max_inspiracion',
                            'expiracion_forzada',
                            'observaciones',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function triaje()
    {
        return $this->belongsTo(Triaje::class, 'triaje_id','id');
    }

}
