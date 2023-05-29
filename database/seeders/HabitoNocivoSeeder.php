<?php

use Illuminate\Database\Seeder;
use App\Models\TipoHabito;

class HabitoNocivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoHabito::firstOrCreate(
            [
                "nombre"=>"Alcohol",
                "estado_registro"=>"A",
            ]
        );
        TipoHabito::firstOrCreate(
            [
                "nombre"=>"Tabaco",
                "estado_registro"=>"A",
            ]
        );
        TipoHabito::firstOrCreate(
            [
                "nombre"=>"Droga",
                "estado_registro"=>"A",
            ]
        );
        TipoHabito::firstOrCreate(
            [
                "nombre"=>"Café",
                "estado_registro"=>"A",
            ]
        );
    }
}
