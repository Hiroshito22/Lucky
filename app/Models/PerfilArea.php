<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilArea extends Model
{
    protected $table = 'perfil_area';
    protected $fillable = array(
                'perfil_tipo_id',
                'area_medica_id',
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
    public function area_medica()
    {
        return $this->belongsTo(AreaMedica::class, 'area_medica_id', 'id');
    }
}
