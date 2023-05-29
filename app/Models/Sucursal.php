<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $fillable = array(
                            'nombre',
                            'direccion',
                            "empresa_id",
                            "estado_registro",
                            "distrito_id",
                            "departamento_id",
                            "provincia_id",
                            "latitud",
                            "longitud"

                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function distrito(){
        return $this->belongsTo(Distrito::class);
    }
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }
    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }
    public function trabajadores(){
        return $this->hasMany(Trabajador::class);
    }
}
