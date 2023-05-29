<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentesOculares extends Model
{
    protected $table = 'antecedentes_oculares';
    protected $fillable = array(
                            'antecedentes_oftalmologias_id',
                            'enfermedades_oculares_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function antecedentes_oftalmologias(){
        return $this->belongsTo(AntecedentesOftalmologia::class,'antecedentes_oftalmologias_id','id');
    }

    public function enfermedades_oculares(){
        return $this->belongsTo(EnfermedadesOculares::class,'enfermedades_oculares_id','id');
    }
}
