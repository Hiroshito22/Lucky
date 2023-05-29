<?php

//namespace Database\Seeders;

use App\Models\OpcionEnfermedadOcular;
use Illuminate\Database\Seeder;

class EnfermedadOcularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpcionEnfermedadOcular::firstOrCreate(
            [
                "nombre"=>"Ausente",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionEnfermedadOcular::firstOrCreate(
            [
                "nombre"=>"Normal",
                "estado_registro"=>"A",
            ],
            []
        );
        OpcionEnfermedadOcular::firstOrCreate(
            [
                "nombre"=>"Conservado",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
