<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabito extends Model
{
    protected $table = 'tipo_habito';
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
        return $this->hasMany(Habito::class);
    }
}
