<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilCapacitacion extends Model
{
    protected $table = 'perfil_capacitacion';
    protected $fillable = array(
                'perfil_tipo_id',
                'capacitacion_id',
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
    public function capacitacion()
    {
        return $this->belongsTo(Capacitacion::class, 'capacitacion_id', 'id');
    }
}
