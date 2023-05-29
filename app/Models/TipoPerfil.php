<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPerfil extends Model
{
    protected $table = 'tipo_perfil';
    protected $fillable = array(
                'nombre',
                'estado_registro',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function perfil_tipo()
    {
        return $this->hasOne(PerfilTipo::class);
    }
}
