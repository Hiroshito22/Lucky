<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoAFamiliar extends Model
{
    protected $table = 'fo_a_familiar';
    protected $fillable = array(
                            'familiar_id',
                            'hospital_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function familiar()
    {
        return $this->belongsTo(Familiar::class)->where('estado_registro','A');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class)->where('estado_registro','A');
    }
}
