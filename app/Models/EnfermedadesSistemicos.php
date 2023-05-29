<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadesSistemicos extends Model
{
    protected $table = 'enfermedades_sistemicos';
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

    // public function antecendentes_oculares(){
    //     return $this->hasMany(AntecedentesSistemico::class);
    // }

    public function antecedentes_sistemicos(){
        return $this->hasMany(AntecedentesSistemico::class);
    }

    public function patologias(){
        return $this->belongsTo(Patologia::class,'patologia_id','id');
    }
}
