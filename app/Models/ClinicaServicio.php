<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClinicaServicio extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    protected $table = 'clinica_servicio';
    protected $fillable = array(
                            'servicio_id',
                            // 'clinica_paquete_id',
                            'clinica_id',
                            'ficha_medico_ocupacional_id',
                            'nombre',
                            'icono',
                            'parent_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at','pivot'
    ];

    public function getParentKeyName()
    {
        return 'parent_id';
    }
    public function getLocalKeyName()
    {
        return 'id';
    }
    public function getCustomPaths()
    {
        return [
            [
                'name' => 'slug',
                'column' => 'nombre',
                'separator' => '/',
            ],
        ];
    }

    public function clinica()
    {
        return $this->belongsTo(Clinica::class, 'clinica_id', 'id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id', 'id');
    }
    public function DatoOcupacional(){
        return $this->hasMany(DatoOcupacional::class);
    }
    public function DatosEkg(){
        return $this->hasMany(DatosEkg::class);
    }
    public function PreguntasEkg(){
        return $this->hasMany(PreguntasEkg::class);
    }
    public function antecedentepersonales()
    {
        return $this->hasMany(AntecedentePersonal::class);
    }
    public function preguntas()
    {
        return $this->hasMany(Preguntas::class);
    }
    public function paquete_servicio()
    {
        return $this->hasOne(PaqueteServicio::class);
    }
    // public function paquetes()
    // {
    //     //return $this->belongsToMany(ClinicaPaquete::class);
    //     return $this->belongsToMany(ClinicaPaquete::class, 'clinica_paquete_servicio', 'clinica_servicio_id', 'clinica_paquete_id', 'clinica_id');
    //     return $this->belongsToMany(Paquete::class);
    // }

    public function clinica_paquete()
    {
        //return $this->belongsToMany(ClinicaPaquete::class);
        return $this->belongsToMany(ClinicaPaquete::class, 'clinica_paquete_servicio', 'clinica_servicio_id', 'clinica_paquete_id', 'clinica_id');
        //return $this->belongsToMany(Paquete::class);
        return $this->hasMany(ClinicaPaquete::class);
    }

}
