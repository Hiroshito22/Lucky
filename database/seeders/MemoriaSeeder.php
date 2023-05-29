<?php

use Illuminate\Database\Seeder;
use App\Models\Memoria;
class MemoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Memoria::updateOrCreate(
            [
                "nombre"=>"Corto Plazo",
                "estado_registro"=>"A",
            ]
        );
        Memoria::updateOrCreate(
            [
                "nombre"=>"Mediano Plazo",
                "estado_registro"=>"A",
            ]
        );
        Memoria::updateOrCreate(
            [
                "nombre"=>"Largo Plazo",
                "estado_registro"=>"A",
            ]
        );
    }
}
