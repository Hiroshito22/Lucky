<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table = 'historia_clinica';
    protected $fillable = array(
                            'fecha_emision',
                            'persona_id',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function persona(){
        return $this->belongsTo(Persona::class);
    }
    
}
