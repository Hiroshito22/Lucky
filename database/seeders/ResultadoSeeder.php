<?php

// namespace Database\Seeders;

use App\Models\Resultado;
use Illuminate\Database\Seeder;

class ResultadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Resultado::firstOrCreate(
            [
                "nombre"=>"Apto",
                "estado_registro"=>"A",
            ],
            []
        );
        Resultado::firstOrCreate(
            [
                "nombre"=>"Apto con observación",
                "estado_registro"=>"A",
            ],
            []
        );
        Resultado::firstOrCreate(
            [
                "nombre"=>"Apto con Recomendación",
                "estado_registro"=>"A",
            ],
            []
        );
        Resultado::firstOrCreate(
            [
                "nombre"=>"Apto con Restricciones",
                "estado_registro"=>"A",
            ],
            []
        );
        Resultado::firstOrCreate(
            [
                "nombre"=>"No Apto",
                "estado_registro"=>"A",
            ],
            []
        );
        Resultado::firstOrCreate(
            [
                "nombre"=>"No Apto Temporal",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
