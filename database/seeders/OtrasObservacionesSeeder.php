<?php

//namespace Database\Seeders;

use App\Models\OtrasObservaciones;
use Illuminate\Database\Seeder;

class OtrasObservacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OtrasObservaciones::firstOrCreate(
            [
                "nombre"=>"No evidencia miedo o temor para realizar trabajos en altura (Test de Acrofobia)",
                "estado_registro"=>"A",
            ],[]
        );
        OtrasObservaciones::firstOrCreate(
            [
                "nombre"=>"No evidencia miedo o temor para realizar trabajos en espacios confinados",
                "estado_registro"=>"A",
            ],[]
        );
        OtrasObservaciones::firstOrCreate(
            [
                "nombre"=>"No se evidencia indicadores de somnolencia y fatiga en el área laboral",
                "estado_registro"=>"A",
            ],[]
        );
        OtrasObservaciones::firstOrCreate(
            [
                "nombre"=>"Nivel bajo de estrés laboral según OIT-OMS",
                "estado_registro"=>"A",
            ],[]
        );
        OtrasObservaciones::firstOrCreate(
            [
                "nombre"=>"Nivel bajo de fobia específica",
                "estado_registro"=>"A",
            ],[]
        );
        OtrasObservaciones::firstOrCreate(
            [
                "nombre"=>"No se evidencia signos de demencia. (Test Minimental)",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
