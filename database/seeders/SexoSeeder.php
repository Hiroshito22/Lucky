<?php

use Illuminate\Database\Seeder;
use App\Models\Sexo;
class SexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sexo::firstOrCreate(
            [
                "nombre"=>"Masculino"
            ]
        );
        Sexo::firstOrCreate(
            [
                "nombre"=>"Femenino"
            ]
        );
    }
}
