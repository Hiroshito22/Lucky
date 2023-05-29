<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoVenta extends Model
{
    protected $table = 'estado_venta';
    protected $fillable = array(
        'user_rol_id',
        'lead_id',
        'nombre',
        'descripcion',
        'estado_registro',
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function user_rol(){
        return $this->belongsTo(UserRol::class, 'user_rol_id', 'id');
    }
    public function lead_id(){
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
