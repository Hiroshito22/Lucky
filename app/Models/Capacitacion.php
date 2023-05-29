<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    protected $table = 'capacitacion';
    protected $fillable = array(
                            'bregma_id',
                            'nombre',
                            'precio_referencial',
                            'precio_mensual',
                            'precio_anual',
                            'icono',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at','pivot'
    ];

    public function bregma()
    {
        return $this->belongsTo(Bregma::class, 'bregma_id', 'id');
    }
    public function perfil_capacitacion()
    {
        return $this->HasMany(PerfilCapacitacion::class,);
    }
}
