<?php

use Illuminate\Database\Seeder;
use App\Models\Inteligencia;
class InteligenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"Muy Superior",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"Superior",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"Normal Brillante",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"N. Promedio",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"N. Torpe",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"Fronterizo",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"RM Leve",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"RM Moderado",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"RM Severo",
        //         "estado_registro"=>"A",
        //     ]
        // );
        // Inteligencia::updateOrCreate(
        //     [
        //         "nombre"=>"RM Profundo",
        //         "estado_registro"=>"A",
        //     ]
        // );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"Muy Superior",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"Superior",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"Normal Brillante",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"N. Promedio",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"N. Bajo",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"Fronterizo",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"RM Leve",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"RM Moderado",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"RM Severo",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"RM Profundo",
            ],[]
        );
        Inteligencia::firstOrCreate(
            [
                "nombre"=>"No Aplica",
            ],[]
        );
    }
}
