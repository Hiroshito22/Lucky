<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BregmaServicio extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    protected $table = 'bregma_servicio';
    protected $fillable = array(
                            //'servicio_id',
                            'bregma_id',
                            'icono',
                            'nombre',
                            'descripcion',
                            'parent_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at','pivot'
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

    public function bregma()
    {
        return $this->belongsTo(Bregma::class, 'bregma_id', 'id');
    }

    public function bregma_paquete()
    {
        return $this->belongsTo(BregmaPaquete::class, 'id', 'bregma_servicio_id');
    }

}
