<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detraccion extends Model
{
    protected $table  = 'detraccion';
    protected $fillable = array(
                        'numero_cuenta',
                        'persona_id',
                        'bregma_id',
                        'clinica_id',
                        'empresa_id',
                        'user_rol_id',
                        'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id', 'id');
    }

    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id', 'id');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id', 'id');
    }

    public function clinica(){
        return $this->belongsTo(Clinica::class,'clinica_id', 'id');
    }

    public function user_rol(){
        return $this->belongsTo(UserRol::class,'user_rol_id', 'id');
    }

}
