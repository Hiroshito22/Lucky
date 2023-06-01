<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';
    protected $fillable = array(
                            'provincia',
                            'departamento_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }
    public function distritos(){
        return $this->hasMany(Distritos::class);
    }
}
