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
            "nombre" => "stanley"
        ]);
        Marca::updateOrCreate([
            "nombre" => "Makita"
        ]);
        Marca::updateOrCreate([
            "nombre" => "Bosh"
        ]);
        Marca::updateOrCreate([
            "nombre" => "Truper"
        ]);
        Marca::updateOrCreate([
            "nombre" => "DeWalt"
        ]);
        Marca::updateOrCreate([
            "nombre" => "Rotoplas"
        ]);
        Marca::updateOrCreate([
            "nombre" => "Phillips"
        ]);
        Marca::updateOrCreate([
            "nombre" => "Urrea"
        ]);
        Marca::updateOrCreate([
            "nombre" => "Black&Decker"
        ]);
    }
}
