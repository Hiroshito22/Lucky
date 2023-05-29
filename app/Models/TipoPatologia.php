<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPatologia extends Model
{
    protected $table = 'tipo_patologia';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function patologias(){
        $this->hasMany(Patologia::class)->where('estado_registro','!=','I');
    }
}
