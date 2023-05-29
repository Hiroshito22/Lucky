<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BregmaPaqueteArea extends Model
{
    use HasFactory;
    protected $table = 'bregma_paquete_area';
    protected $fillable = array(
                            'area_medica_id',
                            'bregma_paquete_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function area_medica(){
        return $this->belongsTo(AreaMedica::class,'area_medica_id','id');
    }
    public function bregma_paquete(){
        return $this->belongsTo(BregmaPaquete::class,'bregma_paquete_id','id');
    }
}
