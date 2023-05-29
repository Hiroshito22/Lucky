<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frecuencia extends Model
{
    protected $table = 'frecuencia';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function habitos()
    {
        return $this->hasMany(Habito::class,'habito_deporte_id','id');
    }
}
