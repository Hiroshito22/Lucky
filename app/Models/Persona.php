<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Persona extends Model
{
    protected $table = 'persona';
    protected $fillable = array(
                            'foto',
                            'numero_documento',
                            'tipo_documento_id',
                            'nombres',
                            'apellido_paterno',
                            'apellido_materno',
                            'cargo',
                            'fecha_nacimiento',
                            'hobbies',
                            'celular',
                            'telefono',
                            'correo',
                            'direccion',
                            'telefono_emergencia',
                            'contacto_emergencia',
                            'distrito_id',
                            'distrito_domicilio_id',
                            'estado_civil_id',
                            'religion_id',
                            'sexo_id',
                            'grado_instruccion_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class,'tipo_documento_id','id');
    }

    public function detracciones(){
        return $this->hasMany('App\Models\detraccion','persona_id','id')->where('registro','A');
    }
    public function distrito(){
        return $this->belongsTo(Distritos::class,'distrito_id','id');
    }
    public function distrito_domicilio(){
        return $this->belongsTo(TipoDocumento::class,'distrito_domocilio_id','id');
    }
    public function estado_civil(){
        return $this->belongsTo(EstadoCivil::class,'estado_civil_id','id');
    }
    public function religion(){
        return $this->belongsTo(Religion::class,'religion_id','id');
    }
    public function sexo(){
        return $this->belongsTo(Sexo::class,'sexo_id','id');
    }
    public function grado_instruccion(){
        return $this->belongsTo(GradoInstruccion::class,'grado_instruccion_id','id');
    }
    public function users_roles(){
        return $this->hasMany(UserRol::class);
    }

    public function getFotoAttribute($value)
    {
        if ($value) {
            return url(Storage::url('/public/personas' . '/' . $value));
        }
        return $value;
    }
}
