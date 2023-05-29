<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebaPsicologica extends Model
{
    protected $table = 'pruebas_psicologicas';
    protected $fillable = array(
                            'psicologia_id',
                            'prueba_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function prueba(){
        return $this->belongsTo(Prueba::class,'prueba_id','id');
    }

    public function psicologia(){
        return $this->belongsTo(Psicologia::class,'psicologia_id','id');
    }
}
