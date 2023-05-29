<?php

use Illuminate\Database\Seeder;
use App\Models\Articulacion;
class ArticulacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Articulacion::updateOrCreate(
            [
                "nombre"=>"Con dificultad",
                "estado_registro"=>"A",
            ]
        );
        Articulacion::updateOrCreate(
            [
                "nombre"=>"Sin Dificultad",
                "estado_registro"=>"A",
            ]
        );
        
    }
}
