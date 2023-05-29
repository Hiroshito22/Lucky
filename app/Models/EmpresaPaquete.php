<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaPaquete extends Model
{
    protected $table = 'empresa_paquete';
    protected $fillable = array(
                            'empresa_id',
                            'paquete_id',
                            'precio',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id')->where('estado_registro','A');
    }
    public function paquete(){
        return $this->belongsTo(Paquete::class,'paquete_id','id')->where('estado_registro','A');
    }
}
