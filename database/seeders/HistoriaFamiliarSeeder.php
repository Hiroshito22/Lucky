<?php

//namespace Database\Seeders;

use App\Models\HistoriaFamiliar;
use Illuminate\Database\Seeder;

class HistoriaFamiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistoriaFamiliar::firstOrCreate(
            [
                "nombre"=>"Soltero, vive con su  ",
                "estado_registro"=>"A",
            ],[]
        );
        HistoriaFamiliar::firstOrCreate(
            [
                "nombre"=>"Conviviente, vive con su  ",
                "estado_registro"=>"A",
            ],[]
        );
        HistoriaFamiliar::firstOrCreate(
            [
                "nombre"=>"Casado, vive con su  ",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
