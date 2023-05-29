<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BregmaContratoPaquete extends Model
{
    use HasFactory;
    protected $table = 'bregma_contrato_paquete';
    protected $fillable = array(
                            'contrato_id',
                            'bregma_paquete_id',
                            'estado_registro'
                            );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','updated_at','delete_at'
    ];
    public function contrato(){
        return $this->belongsTo(Contrato::class,'contrato_id','id');
    }
    public function bregma_paquete(){
        return $this->belongsTo(BregmaPaquete::class,'bregma_paquete_id','id');
    }
}
