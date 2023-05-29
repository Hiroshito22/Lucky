<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamBig extends Model
{
    use HasFactory;
    protected $table = 'team_big';
    protected $fillable = array(
                            'nombre',
                            'medida',
                            "contenido",
                            "caducidad",
                            "estado_registro",

                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
