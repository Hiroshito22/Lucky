<?php

use Illuminate\Database\Seeder;
use App\Models\Tono;
class TonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tono::updateOrCreate(
            [
                "nombre"=>"Bajo",
                "estado_registro"=>"A",
            ]
        );
        Tono::updateOrCreate(
            [
                "nombre"=>"Moderado",
                "estado_registro"=>"A",
            ]
        );
        Tono::updateOrCreate(
            [
                "nombre"=>"Alto",
                "estado_registro"=>"A",
            ]
        );
        
    }
}
