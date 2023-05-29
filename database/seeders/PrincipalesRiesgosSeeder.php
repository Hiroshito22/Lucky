<?php

use Illuminate\Database\Seeder;
use App\Models\PrincipalRiesgo;
class PrincipalesRiesgosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrincipalRiesgo::updateOrCreate(
            [
                "nombre"=>"Golpes",
                "estado_registro"=>"A",
            ]
        );
        PrincipalRiesgo::updateOrCreate(
            [
                "nombre"=>"Heridas",
                "estado_registro"=>"A",
            ]
        );
        PrincipalRiesgo::updateOrCreate(
            [
                "nombre"=>"Fracturas",
                "estado_registro"=>"A",
            ]
        );
        
    }
}
