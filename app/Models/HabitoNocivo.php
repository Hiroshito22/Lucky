<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitoNocivo extends Model
{
    protected $table = 'habito_nocivo';
    protected $fillable = array(
                            //'clinica_servicio_id',
                            //'habito_deporte_id',
                            'medicamento',
                            'observaciones',
                            'deporte',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    // public function servicio_clinica()
    // {
    //     return $this->belongsTo(ServicioClinica::class,'servicio_clinica_id','id');
    // }
    // public function clinica_servicio()
    // {
    //     return $this->belongsTo(ServicioClinica::class,'clinica_servicioS_id','id');
    // }
    public function triaje(){
        return $this->hasOne(Triaje::class);
    }
    
    public function habito_deporte()
    {
        return $this->hasMany(HabitoDeporte::class);
    }
    public function habitos()
    {
        return $this->hasMany(Habito::class);
    }
}
