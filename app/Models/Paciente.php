<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'paciente';
    protected $fillable = array(
                            'empresa_personal_id',
                            'persona_id',
                            'hoja_ruta_id',
                            'fecha',
                            'clinica_local_id',
                            'estado_atencion',
                            'estado_registro',
                            'clinica_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function empresa_personal()
    {
        return $this->belongsTo(EmpresaPersonal::class,'empresa_personal_id','id');
    }

    public function hoja_ruta()
    {
        return $this->belongsTo(HojaRuta::class,'hoja_ruta_id','id');
    }
    public function clinica_local()
    {
        return $this->belongsTo(ClinicaLocal::class,'clinica_local_id','id');
    }
}
