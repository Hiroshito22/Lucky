<?php

//namespace Database\Seeders;

use App\Models\CoordinacionVisomotriz;
use Illuminate\Database\Seeder;

class CoordinacionVisomotrizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //primera coordinacion visomotriz
        CoordinacionVisomotriz::firstOrCreate(
            [
                "nombre"=>"Lento"
            ]
        );
        //segunda coordinacion visomotriz
        CoordinacionVisomotriz::firstOrCreate(
            [
                "nombre"=>"moderado"
            ]
        );
        //tercera coordinacion visomotriz
        CoordinacionVisomotriz::firstOrCreate(
            [
                "nombre"=>"Fluido"
            ]
        );
        //cuarta coordinacion visomotriz
        CoordinacionVisomotriz::firstOrCreate(
            [
                "nombre"=>"No Aplica"
            ]
        );
    }
}
