<?php

use Illuminate\Database\Seeder;
use App\Models\GradoInstruccion;
class GradoInstruccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GradoInstruccion::firstOrCreate(
            [
                "nombre"=>"Primaria",
            ]
        );
        GradoInstruccion::firstOrCreate(
            [
                "nombre"=>"Primaria Incompleta",
            ]
        );
        GradoInstruccion::firstOrCreate(
            [
                "nombre"=>"Secundaria",
            ]
        );
        GradoInstruccion::firstOrCreate(
            [
                "nombre"=>"Secundaria Incompleta",
            ]
        );
        GradoInstruccion::firstOrCreate(
            [
                "nombre"=>"Estudios Universitarios",
            ]
        );
        GradoInstruccion::firstOrCreate(
            [
                "nombre"=>"Estudios Universitarios Incompletos",
            ]
        );
    }
}
