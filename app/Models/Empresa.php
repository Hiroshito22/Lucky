<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    protected $fillable = array(
                            'numero_documento',
                            'razon_social',
                            'logo',
                            'distrito_id',
                            'direccion_legal'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function distrito(){
        return $this->belongsTo(Distritos::class,'distrito_id','id');
    }
}
