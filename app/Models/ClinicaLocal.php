<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicaLocal extends Model
{
   
    protected $table = 'clinica_local';
    protected $fillable = array(
                            'clinica_id',
                            'departamento_id',
                            'provincia_id',
                            'distrito_id',
                            'nombre',
                            'direccion',
                            'latitud',
                            'longitud',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    // public function bregma(){
    //     return $this->belongsTo(Bregma::class,'bregma_id', 'id');
    // }
    public function clinica(){
        return $this->belongsTo(Clinica::class,'clinica_id', 'id');
    }
    public function distrito()
    {
        return $this->belongsTo(Distritos::class, 'distrito_id', 'id');
    }
    public function clinica_areas(){
        return $this->hasMany(ClinicaArea::class);
    }
    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }
}
