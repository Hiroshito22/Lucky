<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicaArea extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    protected $table = 'clinica_area';
    protected $fillable = array(
                            'nombre',
                            'estado_registro',
                            'clinica_id',
                            'bregma_id',
                            'empresa_id',
                            'clinica_local_id',
                            'parent_id'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
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
     public function clinica(){
        return $this->belongsTo(Clinica::class,'clinica_id', 'id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function bregma()
    {
        return $this->belongsTo(Bregma::class, 'bregma_id', 'id');
    }
    
    public function clinica_local()
    {
        return $this->belongsTo(ClinicaLocal::class,'clinica_local_id', 'id');
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
    public function bregma_local()
    {
        return $this->belongsTo(BregmaLocal::class, 'bregma_local_id', 'id');
    }
    public function clinica_personal()
    {
        return $this->hasMany(ClinicaPersonal::class);
    }
}
