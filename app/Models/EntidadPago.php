<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadPago extends Model
{
    protected $table = 'entidad_pago';
    protected $fillable = array(
                            'numero_cuenta',
                            'cci',
                            'estado_registro',
                            'entidad_bancaria_id',
                            'persona_id',
                            'bregma_id',
                            'clinica_id',
                            'user_rol_id'
                            );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','update_at','delete_at'
    ];

    public function entidad_bancaria(){
        return $this->belongsTo(EntidadBancaria::class,'entidad_bancaria_id','id');
    }
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id');
    }
}
