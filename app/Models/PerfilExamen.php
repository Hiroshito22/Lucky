<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilExamen extends Model
{
    protected $table = 'perfil_examen';
    protected $fillable = array(
                'perfil_tipo_id',
                'examen_id',
                'estado_registro',
                //'nombre',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function perfil_tipo()
    {
        return $this->belongsTo(PerfilTipo::class, 'perfil_tipo_id', 'id');
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id', 'id');
    }
}
