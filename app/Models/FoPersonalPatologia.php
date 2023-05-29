<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoPersonalPatologia extends Model
{
    protected $table = 'fo_personal_patologia';
    protected $fillable = array(
                            'observaciones',
                            'estado_registro',
                            'patologia_id',
                            'fo_a_personal_id',
                            'hospital_patologia_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
