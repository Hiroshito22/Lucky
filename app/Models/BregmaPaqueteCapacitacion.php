<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BregmaPaqueteCapacitacion extends Model
{
    protected $table = 'bregma_paquete_capacitacion';
    protected $fillable = array(
                            'bregma_paquete_id',
                            'capacitacion_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at','pivot'
    ];

    public function bregma_paquete()
    {
        return $this->belongsTo(BregmaPaquete::class, 'bregma_paquete_id', 'id');
    }

    public function capacitacion()
    {
        return $this->belongsTo(Capacitacion::class, 'capacitacion_id', 'id');
    }
}
