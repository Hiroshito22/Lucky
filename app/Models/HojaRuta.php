<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HojaRuta extends Model
{
    use HasFactory;
    protected $table = 'hoja_ruta';
    protected $fillable = array(
                            'empresa_personal_id',
                            'perfil_tipo_id',
                            'clinica_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function empresa_personal(){
        return $this->belongsTo(EmpresaPersonal::class, 'empresa_personal_id','id');
    }
    public function perfil_tipo(){
        return $this->belongsTo(PerfilTipo::class, 'perfil_tipo_id','id');
    }
    public function clinica(){
        return $this->belongsTo(Clinica::class, 'clinica_id','id');
    }
    public function estado_ruta(){
        return $this->hasManyThrough(EstadoRuta::class, HojaRutaDetalle::class,'hoja_ruta_id','id','id');
    }
    public function hoja_ruta_detalle()
    {
        return $this->hasMany(HojaRutaDetalle::class);
    }
    public function areas_medicas()
    {
        return $this->hasMany(HojaRutaDetalle::class)->where('area_medica_id','!=',null);
    }
}
