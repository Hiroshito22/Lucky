<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Acceso extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    protected $table = 'acceso';
    protected $fillable = array(
                            'url',
                            'label',
                            'icon',
                            'estado_registro',
                            'parent_id',
                            'tipo_acceso',
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
                'column' => 'url',
                'separator' => '/',
            ],
        ];
    }
}