<?php

use Illuminate\Database\Seeder;
use App\Models\Familiar;
class FamiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Familiar::firstOrCreate(
            [
                "nombre"=>"Padre",
                "estado_registro"=>"A",
            ]
        );
        Familiar::firstOrCreate(
            [
                "nombre"=>"Madre",
                "estado_registro"=>"A",
            ]
        );
        Familiar::firstOrCreate(
            [
                "nombre"=>"Hermano",
                "estado_registro"=>"A",
            ]
        );
        Familiar::firstOrCreate(
            [
                "nombre"=>"Abuelo Paterno",
                "estado_registro"=>"A",
            ]
        );
        Familiar::firstOrCreate(
            [
                "nombre"=>"Abuelo Materno",
                "estado_registro"=>"A",
            ]
        );
    }
}
