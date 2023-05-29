<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dias extends Model
{
    protected $table = 'dias';
    protected $fillable = array(
                            'dia',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
