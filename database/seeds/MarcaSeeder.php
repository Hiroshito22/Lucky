<?php

//namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 1"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 2"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 3"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 4"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 5"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 6"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 7"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 8"
        ]);
        Marca::updateOrCreate([
            "nombre" => "ventilador tipo 9"
        ]);
    }
}
