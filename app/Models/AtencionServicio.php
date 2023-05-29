<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtencionServicio extends Model
{
    protected $table = 'atencion_servicio';
    protected $fillable = array(
                            'servicio_id',
                            'atencion_id',
                            'estado_atencion',
                            'hora_inicio',
                            'hora_fin',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }
    public function atencion(){
        return $this->belongsTo(Atencion::class);
    }
}
