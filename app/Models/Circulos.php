<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circulos extends Model
{
    protected $table = 'circulos';
    protected $fillable = array(
                            'nombre',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function estereopsis()
    {
        return $this->hasOne(Estereopsis::class);
    }
}
