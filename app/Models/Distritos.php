<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distritos extends Model
{
    protected $table = 'distritos';
    protected $fillable = array(
                            'distrito',
                            'provincia_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }
    public function clinica_local()
    {
        return $this->hasMany(ClinicaLocal::class)->where('estado_registro','A');
    }
}
