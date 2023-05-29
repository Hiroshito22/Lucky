<?php

//namespace Database\Seeders;

use App\Models\OpcionReflejosPupilares;
use Illuminate\Database\Seeder;

class ReflejoPupilarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpcionReflejosPupilares::firstOrCreate(
            [
                "nombre"=>"Ausente",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionReflejosPupilares::firstOrCreate(
            [
                "nombre"=>"Normal",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionReflejosPupilares::firstOrCreate(
            [
                "nombre"=>"Conservado",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
