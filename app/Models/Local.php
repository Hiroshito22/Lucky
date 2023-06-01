<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;
    protected $table = 'local';
    protected $fillable = array(
                            'direccion',
                            'latitud',
                            'longitud',
                            'nombre_local',
                            'trabajador_id',
                            'empresa_id',
                            'distrito_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function trabajador(){
        return $this->belongsTo(Trabajador::class,'trabajador_id','id');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
    public function distrito(){
        return $this->belongsTo(Distrito::class,'distrito_id','id');
    }
}
