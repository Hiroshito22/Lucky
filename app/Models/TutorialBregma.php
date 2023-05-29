<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorialBregma extends Model
{
    use HasFactory;
    protected $table = 'tutorial_bregma';
    protected $fillable = array(
                            'nombre',
                            'bregma_id',
                            'link',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function bregma(){
        return $this->belongsTo(Bregma::class,'bregma_id','id')->where('estado_registro','A');
    }
}
