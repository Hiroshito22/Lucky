<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnfermedadGeneral extends Model
{
    protected $table = 'enfermedad_general';
    protected $fillable = array(
                            'codigo',
                            'enfermedad_general',
                            'enfermedad_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function enfermedad_especifica(){
        return $this->hasMany(EnfermedadEspecifica::class);
    }
}
