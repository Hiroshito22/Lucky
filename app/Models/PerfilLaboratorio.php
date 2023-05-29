<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilLaboratorio extends Model
{
    protected $table = 'perfil_laboratorio';
    protected $fillable = array(
                'perfil_tipo_id',
                'laboratorio_id',
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

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id', 'id');
    }
}
