<?php

use Illuminate\Database\Seeder;
use App\Models\Frecuencia;
class FrecuenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Frecuencia::firstOrCreate(
            [
                "nombre"=>"Nada",
                "estado_registro"=>"A",
            ]
        );
        Frecuencia::firstOrCreate(
            [
                "nombre"=>"Poco",
                "estado_registro"=>"A",
            ]
        );
        Frecuencia::firstOrCreate(
            [
                "nombre"=>"Regular",
                "estado_registro"=>"A",
            ]
        );
        Frecuencia::firstOrCreate(
            [
                "nombre"=>"Excesivo",
                "estado_registro"=>"A",
            ]
        );
        Frecuencia::firstOrCreate(
            [
                "nombre"=>"Niega",
                "estado_registro"=>"A",
            ]
        );
    }
}
