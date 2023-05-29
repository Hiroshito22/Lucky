<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentesSistemico extends Model
{
    protected $table = 'antecedentes_sistemicos';
    protected $fillable = array(
                            'antecedentes_oftalmologias_id',
                            'enfermedades_sistemicos_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function antecedentes_oftalmologias(){
        return $this->belongsTo(AntecedentesOftalmologia::class,'antecedentes_oftalmologias_id','id');
    }

    public function enfermedades_sistemico(){
        return $this->belongsTo(EnfermedadesSistemicos::class,'enfermedades_sistemicos_id','id');
    }

    
}
