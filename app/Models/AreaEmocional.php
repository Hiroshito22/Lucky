<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaEmocional extends Model
{
    protected $table = 'area_emocional';
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
