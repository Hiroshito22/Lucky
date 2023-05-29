<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StereoFlyTest extends Model
{
    protected $table = 'stereo_fly_test';
    protected $fillable = array(
                            'nombre',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function estereopsis()
    {
        return $this->hasOne(Estereopsis::class);
    }
}
