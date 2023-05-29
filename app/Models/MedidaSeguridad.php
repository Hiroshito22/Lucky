<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedidaSeguridad extends Model
{
    protected $table = 'medidas_seguridad';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function DatoOcupacional(){
        return $this->hasOne(DatoOcupacional::class);
    }
}
