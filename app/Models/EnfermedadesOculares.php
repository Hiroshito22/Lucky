<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadesOculares extends Model
{
    protected $table = 'enfermedades_oculares';
    protected $fillable = array(
                'patologia_id',
                // 'clinica_id',
                // 'activo',
                'estado_registro',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function patologias(){
        return $this->belongsTo(Patologia::class,'patologia_id','id');
    }
}
