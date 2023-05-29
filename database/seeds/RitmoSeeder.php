<?php

use Illuminate\Database\Seeder;
use App\Models\Ritmo;
class RitmoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ritmo::updateOrCreate(
            [
                "nombre"=>"Lento",
                "estado_registro"=>"A",
            ]
        );
        Ritmo::updateOrCreate(
            [
                "nombre"=>"Rapido",
                "estado_registro"=>"A",
            ]
        );
        Ritmo::updateOrCreate(
            [
                "nombre"=>"Fluido",
                "estado_registro"=>"A",
            ]
        );
        
    }
}
