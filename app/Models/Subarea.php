<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    protected $table = 'subarea';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                            'empresa_id',
                            'area_id',
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
    public function area(){
        return $this->belongsTo(Area::class);
    }
    // public function bregma()
    // {
    //     return $this->belongsTo(Bregma::class,'bregma_id', 'id');
    // }
}
