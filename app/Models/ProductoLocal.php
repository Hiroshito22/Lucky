<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoLocal extends Model
{
    use HasFactory;
    protected $table = 'producto_local';
    protected $fillable = array(
                            'producto_id',
                            'local_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
    }
    public function local(){
        return $this->belongsTo(Local::class,'local_id','id');
    }
}
