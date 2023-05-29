<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnostico';
    protected $fillable = array(
                            'hc_trabajador_id',
                            'servicio_id',
                            'enfermedad_id',
                            'enfermedad_general_id',
                            'enfermedad_especifica_id',
                            'estado_registro',
                            'atencion_id',
                            'superarea_id',
                            'area_id',
                            'subarea_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }
    public function enfermedad(){
        return $this->belongsTo(Enfermedad::class);
    }
    public function enfermedad_general(){
        return $this->belongsTo(EnfermedadGeneral::class);
    }
    public function enfermedad_especifica(){
        return $this->belongsTo(EnfermedadEspecifica::class);
    }
    public function historia_trabajador(){
        return $this->belongsTo(HCTrabajador::class);
    }
}
