<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $fillable = array(
                            'departamento',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function provincias(){
        return $this->hasMany(Provincia::class);
    }
    // public function clinica_local()
    // {
    //     return $this->hasMany(ClinicaLocal::class)->where('estado_registro','A');
    // }
}
