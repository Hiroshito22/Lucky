<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaMedica extends Model
{
    use HasFactory;
    protected $table = 'area_medica';
    protected $fillable = array(
                            'bregma_id',
                            'nombre',
                            'icono',
                            'precio_referencial',
                            'precio_mensual',
                            'precio_anual',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id');
    }
    public function perfil_area()
    {
        return $this->HasMany(PerfilArea::class);
    }
}