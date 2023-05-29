<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaTrabajador extends Model
{
    protected $table = 'ficha_trabajador';
    protected $fillable = array(
                            'ficha_ocupacional_id',
                            'ficha_psicologica_ocupacional_id',
                            'trabajador_id',
                            'nombres',
                            'apellido_paterno',
                            'apellido_materno',
                            'fecha_nacimiento',
                            'edad',
                            'numero_documento',
                            'tipo_documento_id',
                            'hijos_vivos',
                            'dependientes',
                            'direccion',
                            'distrito_id',
                            'residencia_lugar_trabajo',
                            'tiempo_residencia',
                            'grado_instruccion_id',
                            'telefono',
                            'email',
                            'foto',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }
    public function historia_clinica(){
        return $this->belongsTo(HistoriaClinica::class);
    }
}
