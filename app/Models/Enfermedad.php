<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enfermedad extends Model
{
    protected $table = 'enfermedad';
    protected $fillable = array(
                            'enfermedad',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function enfermedad_general(){
        return $this->hasMany(EnfermedadGeneral::class);
    }
    public function enfermedad_especifica(){
        return $this->hasMany(EnfermedadEspecifica::class);
    }
}
