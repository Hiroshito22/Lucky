<?php

use Illuminate\Database\Seeder;
use App\Models\Presentacion;
class PresentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Presentacion::updateOrCreate(
            [
                "nombre"=>"Adecuado",
                "estado_registro"=>"A",
            ]
        );
        Presentacion::updateOrCreate(
            [
                "nombre"=>"Inadecuado",
                "estado_registro"=>"A",
            ]
        );
        
    }
}
