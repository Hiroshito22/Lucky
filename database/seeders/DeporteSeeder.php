<?php

use Illuminate\Database\Seeder;
use App\Models\Deporte;
class DeporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deporte::firstOrCreate(
            [
                "nombre"=>"Fútbol",
                "estado_registro"=>"A",
            ]
        );
        Deporte::firstOrCreate(
            [
                "nombre"=>"Baloncesto",
                "estado_registro"=>"A",
            ]
        );
        Deporte::firstOrCreate(
            [
                "nombre"=>"Natación",
                "estado_registro"=>"A",
            ]
        );
        Deporte::firstOrCreate(
            [
                "nombre"=>"Voleibol",
                "estado_registro"=>"A",
            ]
        );
        Deporte::firstOrCreate(
            [
                "nombre"=>"Otros Deportes",
                "estado_registro"=>"A",
            ]
        );
    }
}
