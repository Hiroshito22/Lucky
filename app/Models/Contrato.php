<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contrato';
    protected $fillable = array(
                            'tipo_cliente_id',
                            'bregma_id',
                            'clinica_id',
                            'empresa_id',
                            'bregma_paquete_id',
                            'fecha_inicio',
                            'fecha_vencimiento',
                            'estado_contrato',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function clinica()
    {
        return $this->belongsTo(Clinica::class,'clinica_id','id')->where('estado_registro', 'A');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class,'empresa_id','id')->where('estado_registro', 'A');
    }
    public function bregma()
    {
        return $this->belongsTo(Bregma::class,'bregma_id','id')->where('estado_registro', 'A');
    }
    public function tipo_cliente(){
        return $this->belongsTo(TipoCliente::class,'tipo_cliente_id','id')->where('estado_registro', 'A');
    }
}
