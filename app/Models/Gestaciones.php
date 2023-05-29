<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestaciones extends Model
{
    protected $table = 'gestaciones';
    protected $fillable = array(
                            'gestaciones',
                            'abortos',
                            'partos',
                            'p_prematuros',
                            'p_eutacico',
                            'p_distocias',
                            'cesareas',
                            'fecha_cesarea',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function gestaciones(){
        return $this->hasOne(AntecedenteGinecologico::class);
    }
}
