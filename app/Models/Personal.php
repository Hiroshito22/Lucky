<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    protected $fillable = array(
                            'persona_id',
                            'estado_registro',
                            'hospital_id',
                            'vehiculo_id',
                            'user_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    public function user(){
        return $this->belongsTo("App\User",'persona_id','id');
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class,'vehiculo_id','id');
    }
}
