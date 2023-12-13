<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSalida extends Model
{
    use HasFactory;
    protected $table = 'registro_salida';
    protected $fillable = array(
                            'fecha_salida',
                            'destinatario_id',
                            'almacen_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }
    public function destinatario(){
        return $this->belongsTo(Destinatario::class,'destinatario_id','id');
    }
}
