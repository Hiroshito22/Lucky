<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFamiliar extends Model
{
    protected $table = 'tipo_familiar';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
    public function familiares()
    {
        return $this->hasMany(Familiar::class);
    }
}
