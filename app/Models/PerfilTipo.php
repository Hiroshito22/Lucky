<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilTipo extends Model
{
    protected $table = 'perfil_tipo';
    protected $fillable = array(
                'perfil_id',
                'tipo_perfil_id',
                'precio',
                'estado_registro',
                //'nombre',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class,'perfil_id','id');
    }
    public function tipo_perfil()
    {
        return $this->belongsTo(TipoPerfil::class,'tipo_perfil_id','id');
    }
    // public function perfil_area()
    // {
    //     return $this->HasMany(PerfilArea::class);
    // }
    // public function perfil_capacitacion()
    // {
    //     return $this->HasMany(PerfilCapacitacion::class);
    // }
    // public function perfil_laboratorio()
    // {
    //     return $this->HasMany(PerfilLaboratorio::class);
    // }
    // public function perfil_examen()
    // {
    //     return $this->HasMany(PerfilExamen::class);
    // }

    //igual que el otro, cambiar el nombre
    public function areas_medicas()
    {
        return $this->HasMany(PerfilArea::class);
    }
    public function capacitacion()
    {
        return $this->HasMany(PerfilCapacitacion::class);
    }
    public function laboratorio()
    {
        return $this->HasMany(PerfilLaboratorio::class);
    }
    public function examenes()
    {
        return $this->HasMany(PerfilExamen::class);
    }
    public function areas_medica()
    {
        return $this->belongsToMany(AreaMedica::class, 'perfil_area')->wherePivot('estado_registro','A');
    }
    public function capacitaciones()
    {
        return $this->belongsToMany(Capacitacion::class, 'perfil_capacitacion')->wherePivot('estado_registro','A');
    }
    public function laboratorios()
    {
        return $this->belongsToMany(Laboratorio::class, 'perfil_laboratorio')->wherePivot('estado_registro','A');
    }
    public function examen()
    {
        return $this->belongsToMany(Examen::class, 'perfil_examen')->wherePivot('estado_registro','A');
    }
}
