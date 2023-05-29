<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class PersonalCargo extends Model
{
    protected $table = 'personal_cargo';
    protected $fillable = array(
                            'personal_id',
                            'estado_registro',
                            'cargo_id',
                            'firma',
                            'hospital_id',
                            
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function getFirmaAttribute($value)
    {
        if ($value) {
            return url(Storage::url('public/firmas' . '/' . $value));
        }
        return $value;
    }
    public function personal(){
        return $this->belongsTo(Personal::class,'personal_id','id')->where('estado_registro','!=','I');
    }
    public function cargo(){
        return $this->belongsTo(Cargo::class,'cargo_id','id')->where('estado_registro','!=','I');
    }
}
