<?php

//namespace Database\Seeders;

use App\Models\UnidadMedida;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadMedida::updateOrCreate([
            "nombre" => "Kilos",
            "codigo" => "1",
            "simbolo" => "Kg",
        ]);
        UnidadMedida::updateOrCreate([
            "nombre" => "Sacos",
            "codigo" => "2",
            "simbolo" => "sacos",
        ]);
        UnidadMedida::updateOrCreate([
            "nombre" => "Granel",
            "codigo" => "3",
            "simbolo" => "Grn",
        ]);
        UnidadMedida::updateOrCreate([
            "nombre" => "Gramos",
            "codigo" => "4",
            "simbolo" => "Gr",
        ]);
    }
}
