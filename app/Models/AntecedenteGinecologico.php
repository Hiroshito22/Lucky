<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteGinecologico extends Model
{
    protected $table = 'antecedente_ginecologico';
    protected $fillable = array(
                            'fur',
                            'rc',
                            'fup',
                            'menarquia',
                            'ultimopap',
                            'estado',
                            'mamografia_id',
                            'gestaciones_id',
                            'metodos_anticonceptivos',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function mamografia(){
        return $this->belongsTo(Mamografia::class,'mamografia_id','id');
    }
    public function gestaciones(){
        return $this->belongsTo(Gestaciones::class,'gestaciones_id','id');
    }
    public function triaje(){
        return $this->hasOne(Triaje::class);
    }
}
