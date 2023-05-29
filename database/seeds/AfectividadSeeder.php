<?php

// namespace Database\Seeders;

use App\Models\Afectividad;
use Illuminate\Database\Seeder;

class AfectividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Afectividad::firstOrCreate(
            [
                "nombre"=>"Tendencia a la estabilidad",
            ],[]
        );
        Afectividad::firstOrCreate(
            [
                "nombre"=>"Estable",
            ],[]
        );
        Afectividad::firstOrCreate(
            [
                "nombre"=>"Tendencia a la inestabilidad",
            ],[]
        );
        Afectividad::firstOrCreate(
            [
                "nombre"=>"Inestable",
            ],[]
        );
    }
}
