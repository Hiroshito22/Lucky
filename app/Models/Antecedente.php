<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    protected $table = 'antecedente';
    protected $fillable = array(
                            'antecedente_personal_id',
                            'tipo_antecedente_id',
                            'asociado_trabajo',
                            'descripcion',
                            'fecha_inicio',
                            'fecha_final',
                            'dias_incapacidad',
                            'menoscabo',
                            'estado_registro',
                            
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function antecedentes_personales()
    {
        return $this->belongsTo(AntecedentePersonal::class,'antecedente_personal_id','id')->where('estado_registro','A');
    }
    public function tipos_antecedentes()
    {
        return $this->belongsTo(TipoAntecedente::class,'tipo_antecedente_id','id')->where('estado_registro','A');
    }
}
