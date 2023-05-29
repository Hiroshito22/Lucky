<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioClinica extends Model
{
    protected $table = 'servicio_clinica';
    protected $fillable = array(
                            'servicio_id',
                            'clinica_id',
                            "estado_registro",
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function antecedentepersonales()
    {
        return $this->hasMany(AntecedentePersonal::class);
    }
    public function DatoOcupacional(){
        return $this->hasOne(DatoOcupacional::class);
    }
    public function servicios()
    {
        return $this->belongsTo(Servicio::class,'id','servicio_id');
    }
    public function clinicas()
    {
        return $this->belongsTo(Clinica::class,'id','clinica_id');
    }
}
