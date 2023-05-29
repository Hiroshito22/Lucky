<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Servicio extends Model
{
    protected $table = 'servicio';
    protected $fillable = array(
                            // 'precio',
                            // 'nombre',
                            // 'empresa_id',
                            // "estado_registro",
                            // "icon",
                            'nombre',
                            'precio',
                            'icon',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function getIconAttribute($value)
    {
        if ($value) {
            return url(Storage::url('public/servicio/icon' . '/' . $value));
        }
        return $value;
    }
}
