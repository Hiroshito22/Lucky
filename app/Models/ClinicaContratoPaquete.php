<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicaContratoPaquete extends Model
{
    use HasFactory;
    protected $table = 'clinica_contrato_paquete';
    protected $fillable = array(
                            'contrato_id',
                            'clinica_paquete_id',
                            'estado_registro'
                            );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','updated_at','delete_at'
    ];
    public function contrato(){
        return $this->belongsTo(Contrato::class,'contrato_id','id');
    }
    public function clinica_paquete(){
        return $this->belongsTo(ClinicaPaquete::class,'clinica_paquete_id','id');
    }
}
