<?php

// namespace Database\Seeders;

use App\Models\AreaCognitiva;
use Illuminate\Database\Seeder;

class AreaCognitivaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreaCognitiva::firstOrCreate(
            [
                "nombre"=>"Se ubica en la categoría Normal promedio",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaCognitiva::firstOrCreate(
            [
                "nombre"=>"Se encuentra en la categoría inferior al promedio",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaCognitiva::firstOrCreate(
            [
                "nombre"=>"Se ubica en la categoría promedio bajo",
                "estado_registro"=>"A",
            ],
            []
        );
        AreaCognitiva::firstOrCreate(
            [
                "nombre"=>"Se encuentra en la categoría Superior al promedio",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
