<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaLocal extends Model
{
    use HasFactory;
    protected $table = 'empresa_local';
    protected $fillable = array(
                            'nombre',
                            'direccion',
                            'latitud',
                            'longitud',
                            'empresa_id',
                            'departamento_id',
                            'provincia_id',
                            'distrito_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
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
