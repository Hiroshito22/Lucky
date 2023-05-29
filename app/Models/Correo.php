<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correo';
    protected $fillable = array(
                            'correo',
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
}
