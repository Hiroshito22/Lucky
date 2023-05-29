<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionColores extends Model
{
    protected $table = 'vision_colores';
    protected $fillable = array(
                            'ojo_derecho',
                            'ojo_izquierdo',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function test()
    {
        return $this->hasOne(Test::class);
    }

}
