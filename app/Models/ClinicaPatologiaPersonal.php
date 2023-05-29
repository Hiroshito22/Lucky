<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicaPatologiaPersonal extends Model
{
    protected $table = 'clinica_patologia_personal';
    protected $fillable = array(
                            'antecedente_personal_id',
                            'clinica_patologia_id',
                            'comentario',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function antecedente_personal()
    {
        return $this->belongsTo(AntecedentePersonal::class,'antecedente_personal_id', 'id');
    }
    public function clinicas_patologias()
    {
        return $this->belongsTo(ClinicaPatologia::class,'clinica_patologia_id', 'id');
    }
}
