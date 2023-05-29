<?php

//namespace Database\Seeders;

use App\Models\OpcionOjoDerecho;
use Illuminate\Database\Seeder;

class OjoDerechoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpcionOjoDerecho::firstOrCreate(
            [
                "medida"=>"Normal",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionOjoDerecho::firstOrCreate(
            [
                "medida"=>"Anormal",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
