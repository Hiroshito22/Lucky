<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicaPatologiaFamiliar extends Model
{
    protected $table = 'clinica_patologia_familiar';
    protected $fillable = array(
                'antecedente_familiar_id',
                'patologia_id',
                'familiar_id',
                'comentario',
                'estado_registro',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function antecedente_familiares()
    {
        return $this->belongsTo(AntecedenteFamiliar::class,'antecedente_familiar_id', 'id');
    }
    public function patologias()
    {
        return $this->belongsTo(Patologia::class,'patologia_id', 'id');
    }
    public function familiares()
    {
        return $this->belongsTo(Familiar::class,'familiar_id', 'id');
    }
}
