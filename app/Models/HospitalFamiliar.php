<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalFamiliar extends Model
{
    protected $table = 'hospital_familiar';
    protected $fillable = array(
                            'observaciones',
                            'patologia_id',
                            'fo_a_familiar_id',
                            'hospital_patologia_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function fo_a_familiar()
    {
        return $this->belongsTo(FoAFamiliar::class)->where('estado_registro','A');
    }

    public function patologia()
    {
        return $this->belongsTo(Patologia::class)->where('estado_registro','A');
    }

    public function hospital_patologia()
    {
        return $this->belongsTo(HospitalPatologia::class)->where('estado_registro','A');
    }
}
