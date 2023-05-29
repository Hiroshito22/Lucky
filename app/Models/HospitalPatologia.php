<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalPatologia extends Model
{
    protected $table = 'hospital_patologia';
    protected $fillable = array(
                            'activo',
                            'estado_registro',
                            'patologia_id',
                            'hospital_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function patologia(){
       return $this->belongsTo(Patologia::class,'patologia_id','id')->where('estado_registro','!=','I');
    }
}
