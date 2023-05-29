<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segmento extends Model
{
    protected $table = 'segmento';
    protected $fillable = array(
                            'parpados',
                            'conjuntiva',
                            'cornea',
                            'camara_anterior',
                            'iris',
                            'cristalino',
                            'refle_pupilares',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function examen_segmentado()
    {
        return $this->hasOne(ExamenSegmentado::class);
    }
}
