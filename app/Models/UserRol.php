<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    protected $table = 'users_rol';
    protected $fillable = array(
                            'user_id',
                            'rol_id',
                            'tipo_rol',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id','id');
    }
    public function detraccion(){
        return $this->belongsTo(UserRol::class,'detraccion_id','id');
    }
}
