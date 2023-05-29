<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HojaRutaDetalle extends Model
{
    use HasFactory;
    protected $table = 'hoja_ruta_detalle';
    protected $fillable = array(
                    'hoja_ruta_id',
                    'area_medica_id',
                    'capacitacion_id',
                    'examen_id',
                    'laboratorio_id',
                    'estado_ruta_id',
                    'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function hoja_ruta()
    {
        return $this->belongsTo(HojaRuta::class, 'hoja_ruta_id', 'id');
    }
    public function area_medica()
    {
        return $this->belongsTo(AreaMedica::class, 'area_medica_id', 'id');
    }
    public function capacitacion()
    {
        return $this->belongsTo(ClinicaServicio::class, 'capacitacion_id', 'id');
    }
    public function examen()
    {
        return $this->belongsTo(ClinicaServicio::class, 'examen_id', 'id');
    }
    public function laboratorio()
    {
        return $this->belongsTo(ClinicaServicio::class, 'laboratorio_id', 'id');
    }
    public function estado_ruta()
    {
        return $this->belongsTo(EstadoRuta::class, 'estado_ruta_id', 'id');
    }
}
