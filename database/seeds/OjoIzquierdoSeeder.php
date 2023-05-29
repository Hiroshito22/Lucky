<?php

//namespace Database\Seeders;

use App\Models\OpcionOjoIzquierdo;

use Illuminate\Database\Seeder;

class OjoIzquierdoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpcionOjoIzquierdo::firstOrCreate(
            [
                "medida"=>"Normal",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionOjoIzquierdo::firstOrCreate(
            [
                "medida"=>"Anormal",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
