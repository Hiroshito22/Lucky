<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mamografia extends Model
{
    protected $table = 'mamografia';
    protected $fillable = array(
                            'se_hizo',
                            'fecha',
                            'estado',
                            'resultado',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function mamografia(){
        return $this->hasOne(AntecedenteGinecologico::class);
    }
}
