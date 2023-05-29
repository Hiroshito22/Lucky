<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaArea extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    protected $table = 'empresa_area';
    protected $fillable = array(
                            'nombre',
                            'empresa_local_id',
                            'empresa_id',
                            'parent_id',
                            'estado_registro',
                            'numero_trabajadores'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function getParentKeyName()
    {
        return 'parent_id';
    }
    public function getLocalKeyName()
    {
        return 'id';
    }
    public function getCustomPaths()
    {
        return [
            [                
                'name' => 'slug',
                'column' => 'nombre',
                'separator' => '/',
            ],
        ];
    }
    public function empresa_local(){
        return $this->belongsTo(EmpresaLocal::class,'empresa_local_id','id');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
}
