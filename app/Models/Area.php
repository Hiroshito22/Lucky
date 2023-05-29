<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                            'empresa_id',
                            'superarea_id',
                            'bregma_id',
                            'clinica_id'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    // public function empresa()
    // {
    //     return $this->belongsTo(Empresa::class,'empresa_id', 'id');
    // }

    public function superarea(){
        return $this->belongsTo(Superarea::class);
    }

    // public function bregma()
    // {
    //     return $this->belongsTo(Bregma::class,'bregma_id', 'id');
    // }
    
    public function subareas(){
        return $this->hasMany(Subarea::class);
    }
}
