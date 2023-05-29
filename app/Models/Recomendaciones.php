<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendaciones extends Model
{
    protected $table = 'recomendaciones';
    protected $fillable = array(
                            'nombre',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function diagnostico_final(){
        return $this->hasOne(DiagnosticoFinal::class);
    }
}
