<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordinacionVisomotriz extends Model
{
    protected $table = 'coordinacion_visomotriz';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function examen_mental(){
        return $this->hasMany(ExamenMental::class);
    }
}
