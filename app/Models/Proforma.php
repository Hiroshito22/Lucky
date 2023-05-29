<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $table = 'proforma';
    protected $fillable = array(
        'lead_id',
        'tipo_cliente_id',
        'clinica_empresa_id',
        'bregma_paquete_id',
        'codigo',
        'estado',
        'tipo_negociacion',
        'comentario',
        'documento_proforma',
        'documento_evidencia',
        'estado_registro',
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function lead(){
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
    public function tipo_cliente(){
        return $this->belongsTo(TipoCliente::class, 'tipo_cliente_id', 'id');
    }
    public function clinica_empresa(){
        return $this->belongsTo(Clinicaempresa::class, 'clinica_empresa_id', 'id');
    }
    public function bregma_paquete(){
        return $this->belongsTo(BregmaPaquete::class, 'bregma_paquete_id', 'id');
    }

}
