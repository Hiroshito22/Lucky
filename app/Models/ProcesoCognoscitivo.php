<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoCognoscitivo extends Model
{
    protected $table = 'proceso_cognoscitivo';
    protected $fillable = array(
                            // 'ficha_psicologica_ocupacional_id',
                            // 'clinica_servicio_id',
                            'lucido_atento_id',
                            'pensamiento_id',
                            'percepcion_id',
                            'memoria_id',
                            'inteligencia_id',
                            'apetito_id',
                            'suenno_id',                            // Resulta error con la letra "ñ"
                            'personalidad_id',
                            'afectividad_id',
                            'conducta_sexual_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    // public function clinicas_servicios(){
    //     return $this->belongsTo(ClinicaServicio::class,'clinica_servicio_id','id');
    // }
    public function lucidos_atentos(){
        return $this->belongsTo(LucidoAtento::class,'lucido_atento_id','id');
    }
    public function Pensamientos(){
        return $this->belongsTo(Pensamiento::class,'pensamiento_id','id');
    }
    public function memorias(){
        return $this->belongsTo(Memoria::class,'memoria_id','id');
    }
    public function inteligencias(){
        return $this->belongsTo(Inteligencia::class,'inteligencia_id','id');
    }
    public function apetitos(){
        return $this->belongsTo(Apetito::class,'apetito_id','id');
    }
    public function suennos(){
        return $this->belongsTo(Suenno::class,'suenno_id','id');
    }
    public function personalidades(){
        return $this->belongsTo(Personalidad::class,'personalidad_id','id');
    }
    public function afectividades(){
        return $this->belongsTo(Afectividad::class,'afectividad_id','id');
    }
    public function conductas_sexuales(){
        return $this->belongsTo(ConductaSexual::class,'conducta_sexual_id','id');
    }
    public function percepcion(){
        return $this->belongsTo(Percepcion::class,'percepcion_id','id');
    }
}
