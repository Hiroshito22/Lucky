<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanoMentalmente extends Model
{
    protected $table = 'sano_mentalmentes';
    protected $fillable = array(
                            'respuesta',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function preguntas()
    {
        return $this->hasOne(Preguntas::class);
    }
}
