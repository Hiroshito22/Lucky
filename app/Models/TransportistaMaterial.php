<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportistaMaterial extends Model
{
    protected $table = 'transportista_material';
    protected $fillable = array(
                            'transportista_id',
                            'material_id',
                            'cantidad_disponible',
                            'cantidad_asignada',
                            'cantidad_recojo',
                            'fecha',
                            'estado_recepcion',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function transportista(){
        return $this->belongsTo(Personal::class,'transportista_id','id');
    }
    public function material(){
        return $this->belongsTo(Material::class,'material_id','id');
    }
}
