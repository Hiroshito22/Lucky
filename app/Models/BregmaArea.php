<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BregmaArea extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    protected $table = 'bregma_area';
    protected $fillable = array(
                            'id',
                            'nombre',
                            'bregma_local_id',
                            'bregma_id',
                            'parent_id',
                            'estado_registro',
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
                'name' => 'key',
                'column' => 'id',
                'separator' => '-',
            ],
        ];
    }
    public function bregma_local(){
        return $this->belongsTo(BregmaLocal::class,'bregma_local_id','id');
    }
    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id');
    }
    public function bregma_personal(){
        return $this->hasMany(BregmaPersonal::class);
    }

}
