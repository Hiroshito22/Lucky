<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BregmaLocal extends Model
{
    use HasFactory;
    protected $table = 'bregma_local';
    protected $fillable = array(
                            'nombre',
                            'bregma_id',
                            'departamento_id',
                            'provincia_id',
                            'distrito_id',
                            'direccion',
                            'latitud',
                            'longitud',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id');
    }
    public function departamento(){
        return $this->belongsTo(Departamento::class,'departamento_id','id');
    }
    public function provincia(){
        return $this->belongsTo(Provincia::class,'provincia_id','id');
    }
    public function distrito(){
        return $this->belongsTo(Distritos::class,'distrito_id','id');
    }
}
