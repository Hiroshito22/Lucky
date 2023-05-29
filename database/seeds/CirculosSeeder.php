<?php

// namespace Database\Seeders;

use App\Models\Circulos;
use Illuminate\Database\Seeder;

class CirculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Circulos::firstOrCreate([
            "nombre" => "1-800 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "2-400 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "3-200 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "4-140 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "5-100 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "6-80 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "7-60 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "8-50 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "9-40 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "10-32 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "10-25 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "10-20 sec.",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "No percibe",
        ]);
        Circulos::firstOrCreate([
            "nombre" => "No corresponde",
        ]);

    }
}
