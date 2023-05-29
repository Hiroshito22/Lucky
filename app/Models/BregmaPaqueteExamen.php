<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BregmaPaqueteExamen extends Model
{
    use HasFactory;
    protected $table = 'bregma_paquete_examen';
    protected $fillable = array(
                            'examen_id',
                            'bregma_paquete_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function examen(){
        return $this->belongsTo(Examen::class,'examen_id','id');
    }
    public function bregma_paquete(){
        return $this->belongsTo(BregmaPaquete::class,'bregma_paquete_id','id');
    }
}
