<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memoria extends Model
{
    protected $table = 'memoria';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function proceso_cognoscitivo(){
        return $this->hasOne(ProcesoCognoscitivo::class);
    }
}
