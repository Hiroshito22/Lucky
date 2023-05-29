<?php

use Illuminate\Database\Seeder;
use App\Models\Espacio;
class EspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Espacio::updateOrCreate(
            [
                "nombre"=>"Orientado",
                "estado_registro"=>"A",
            ]
        );
        Espacio::updateOrCreate(
            [
                "nombre"=>"Desorientado",
                "estado_registro"=>"A",
            ]
        );
        
    }
}

