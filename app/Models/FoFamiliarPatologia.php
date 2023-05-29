<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoFamiliarPatologia extends Model
{
    protected $table = 'fo_familiar_patologia';
    protected $fillable = array(
                            'observaciones_finales',
                            'ficha_ocupacional_id',
                            'familiar_id',
                            'hospital_familiar_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function familiar()
    {
        return $this->belongsTo(Familiar::class)->where('estado_registro','A');
    }

    public function hospital_familiar()
    {
        return $this->belongsTo(HospitalFamiliar::class)->where('estado_registro','A');
    }
    public function ficha_ocupacional()
    {
        return $this->belongsTo(FichaOcupacional::class)->where('estado_registro','A');
    }
}
