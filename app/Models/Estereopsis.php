<?php

namespace App\Models;

use Egulias\EmailValidator\Exception\AtextAfterCFWS;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estereopsis extends Model
{
    protected $table = 'estereopsis';
    protected $fillable = array(
                            'stereo_fly_test_id',
                            'circulos_id',
                            'movimiento_ocular_tropias',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function stereo_fly_test(){
        return $this->belongsTo(StereoFlyTest::class, 'stereo_fly_test_id', 'id');
    }
    public function circulos(){
        return $this->belongsTo(Circulos::class, 'circulos_id', 'id');
    }
    public function test()
    {
        return $this->hasOne(Test::class);
    }
}
