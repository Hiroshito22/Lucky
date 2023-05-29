<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BregmaPaquete extends Model
{
    use HasFactory;
    protected $table = 'bregma_paquete';
    protected $fillable = array(
        'bregma_id',
        'clinica_id',
        'bregma_servicio_id',
        'icono',
        'nombre',
        'precio_mensual',
        'precio_anual',
        'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function bregma()
    {
        return $this->belongsTo(Bregma::class, 'bregma_id', 'id');
    }
    public function clinica()
    {
        return $this->belongsTo(Clinica::class, 'clinica_id', 'id');
    }
    public function bregma_servicio()
    {
        return $this->belongsTo(BregmaServicio::class, 'bregma_servicio_id', 'id');
    }
    public function area_medica()
    {
        return $this->hasManyThrough(
            AreaMedica::class,
            BregmaPaqueteArea::class,
            "bregma_paquete_id",
            'id',
            'id',
            'area_medica_id'
        );
    }
    public function capacitacion()
    {
        return $this->hasManyThrough(
            Capacitacion::class,
            BregmaPaqueteCapacitacion::class,
            "bregma_paquete_id",
            'id',
            'id',
            'capacitacion_id'
        );
    }
    public function examen()
    {
        return $this->hasManyThrough(
            Examen::class,
            BregmaPaqueteExamen::class,
            "bregma_paquete_id",
            'id',
            'id',
            'examen_id'
        );
    }
    public function laboratorio()
    {
        return $this->hasManyThrough(
            Laboratorio::class,
            BregmaPaqueteLaboratorio::class,
            "bregma_paquete_id",
            'id',
            'id',
            'laboratorio_id'
        );
    }
}
