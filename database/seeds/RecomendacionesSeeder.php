<?php

// namespace Database\Seeders;

use App\Models\Recomendaciones;
use Illuminate\Database\Seeder;

class RecomendacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recomendaciones::updateOrCreate(
            [
                "nombre"=>"Se le recomienda examen psicológico anualmente",
                "estado_registro"=>"A",
            ],
            []
        );
        Recomendaciones::updateOrCreate(
            [
                "nombre"=>"Reforzar inducción y capacitación en el área de seguridad laboral",
                "estado_registro"=>"A",
            ],
            []
        );
        Recomendaciones::updateOrCreate(
            [
                "nombre"=>"Se sugiere orientación/consejería psicológica",
                "estado_registro"=>"A",
            ],
            []
        );
        Recomendaciones::updateOrCreate(
            [
                "nombre"=>"Practicar ejercicios de relajación y respiración para mejorar el manejo de la ansiedad",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
