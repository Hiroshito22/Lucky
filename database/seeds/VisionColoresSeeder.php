<?php

//namespace Database\Seeders;

use App\Models\OpcionVisionColores;
use Illuminate\Database\Seeder;

class VisionColoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpcionVisionColores::firstOrCreate(
            [
                "nombre"=>"Ausente",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionVisionColores::firstOrCreate(
            [
                "nombre"=>"Normal",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionVisionColores::firstOrCreate(
            [
                "nombre"=>"Conservado",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
