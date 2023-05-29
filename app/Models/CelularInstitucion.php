<?php

namespace App\Models;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class CelularInstitucion extends Model
{
    protected $table = 'celular_institucion';
    protected $fillable = array(
                            'bregma_id',
                            'empresa_id',
                            'persona_id',
                            'clinica_id',
                            'celular',
                            'estado_registro',
                            );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','updated_at','delete_at'
    ];

    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id');
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }

    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }

    public function clinica(){
        return $this->belongsTo(Clinica::class,'clinica_id','id');
    }

    public function personacelular(){
        return $this->hasMany(Persona::class,'celular_id','id');
    }

}
