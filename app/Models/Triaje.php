<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triaje extends Model
{
    protected $table = 'triaje';
    protected $fillable = array(
                            'habito_nocivo_id',
                            'antecedente_personal_id',
                            'antecedente_ginecologico_id',
                            'antecedente_familiar_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function habito_nocivos(){
        return $this->belongsTo(HabitoNocivo::class,'habito_nocivo_id','id');
    }
    public function peso_talla(){
        return $this->hasMany(PesoTalla::class);
    }
    public function antecedente_personales(){
        return $this->belongsTo(AntecedentePersonal::class,'antecedente_personal_id','id');
    }
    public function antecedente_ginecologicos(){
        return $this->belongsTo(AntecedenteGinecologico::class,'antecedente_ginecologico_id','id');
    }
    public function antecedente_familiares(){
        return $this->belongsTo(AntecedenteFamiliar::class,'antecedente_familiar_id','id');
    }
}
