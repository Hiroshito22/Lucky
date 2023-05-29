<?php

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servicio::updateOrCreate([
            'nombre'=>'Triaje',
            
        ],['precio'=>'10',"icon"=>"2-Triaje.svg"]);
        Servicio::updateOrCreate([
            'nombre'=>'Oftalmología',
            
        ],['precio'=>'20',"icon"=>"4-Oftalmología.svg"]);
        Servicio::updateOrCreate([
            'nombre'=>'EKG',
            
        ],['precio'=>'30',"icon"=>"3-EKG.svg"]);
        Servicio::updateOrCreate([
            'nombre'=>'Audiometría',
            
        ],['precio'=>'40',"icon"=>"5-Audiometría.svg"]);
        Servicio::updateOrCreate([
            'nombre'=>'Cardiologia',
            
        ],['precio'=>'50']);
        Servicio::updateOrCreate([
            'nombre'=>'Psicología',
            
        ],['precio'=>'50',"icon"=>"1-psicologia.svg"]);
        Servicio::updateOrCreate([
            'nombre'=>'Medicina General',
            
        ],['precio'=>'50',"icon"=>"7-Medicina General.svg"]);
    }
}
