<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    protected $fillable = array(
                            'razon_social',
                            'gerente_id',
                            'trabajador_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function gerente(){
        return $this->belongsTo(Gerente::class,'gerente_id','id');
    }
    public function trabajador(){
        return $this->belongsTo(Trabajador::class,'trabajador_id','id');
    }
}
