<?php

//namespace Database\Seeders;

use App\Models\MotivoEvaluacion;
use Illuminate\Database\Seeder;

class MotivoEvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MotivoEvaluacion::firstOrCreate(
            [
                "nombre"=>"Evaluación Pre Ocupacional",
                "estado_registro"=>"A",
            ],[]
        );
        MotivoEvaluacion::firstOrCreate(
            [
                "nombre"=>"Evaluación Anual",
                "estado_registro"=>"A",
            ],[]
        );
        MotivoEvaluacion::firstOrCreate(
            [
                "nombre"=>"Evaluación de Retiro",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
