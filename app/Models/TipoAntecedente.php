<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAntecedente extends Model
{
    protected $table = 'tipo_antecedente';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function antecedentes()
    {
        return $this->hasMany(Antecedente::class);
    }
}
