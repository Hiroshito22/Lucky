<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';
    protected $fillable = array(
                'clinica_paquete_id',
                'nombre',
                'precio',
                'estado_registro',
    );
    protected $primaryKey  = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function clinica_paquete()
    {
        return $this->belongsTo(ClinicaServicio::class,'clinica_paquete_id','id');
    }
    // public function perfil_tipo()
    // {
    //     return $this->hasMany(PerfilTipo::class);
    // }
    public function entrada() // solo era cambiar el nombre
    {
        return $this->hasMany(PerfilTipo::class)->where('tipo_perfil_id',1);
    }
    public function rutina() // solo era cambiar el nombre
    {
        return $this->hasMany(PerfilTipo::class)->where('tipo_perfil_id',2);
    }
    public function salida() // solo era cambiar el nombre
    {
        return $this->hasMany(PerfilTipo::class)->where('tipo_perfil_id',3);
    }
}
