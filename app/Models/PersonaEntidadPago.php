<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaEntidadPago extends Model
{
    protected $table = 'persona_entidad_pago';
    protected $fillable = array(
                                'entidad_bancaria_id',
                                'persona_id',
                                // 'bregma_id',
                                'clinica_id',
                                'user_rol_id',
                                'numero_cuenta',
                                'cci',
                                'estado_registro'

                            );
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function entidad_bancaria()
    {
        return $this->belongsTo(EntidadBancaria::class,'entidad_bancaria_id','id');
    }
    public function user_rol()
    {
        return $this->belongsTo(UserRol::class,'user_rol','id');
    }
}
