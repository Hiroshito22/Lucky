<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BregmaOperacion extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    protected $table = 'bregma_operacion';
    protected $fillable = array(
                            'bregma_id',
                            'nombre',
                            'icono',
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
}
