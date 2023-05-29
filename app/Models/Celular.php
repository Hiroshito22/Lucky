<?php

namespace App\Models;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class Celular extends Model
{
    protected $table = 'celular';
    protected $fillable = array(
                            'celular',
                            'estado_registro',
                            // 'empresa_id',
                            'persona_id',
                            // 'clinica_id',
                            //'bregma_id'
                            );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','updated_at','delete_at'
    ];
    // public function empresa(){
    //     return $this->belongsTo(Empresa::class,'empresa_id','id');
    // }
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    // public function clinica(){
    //     return $this->belongsTo(Clinica::class,'clinica_id','id');
    // }
    /*public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id');
    }*/
    public function personacelular(){
        return $this->hasMany(Persona::class,'celular_id','id');
    }
}
