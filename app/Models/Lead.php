<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'lead';
    protected $fillable = array(
        'tipo_lead_id',
        'contrato_id',
        'bregma_paquete_id',
        'descripcion',
        'estado_registro',
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function tipo_lead(){
        return $this->belongsTo(TipoLead::class, 'tipo_lead_id', 'id');
    }
    public function contrato(){
        return $this->belongsTo(Contrato::class, 'contrato_id', 'id');
    }
    public function bregma_paquete(){
        return $this->belongsTo(BregmaPaquete::class, 'bregma_paquete_id', 'id');
    }
}
