<?php

//namespace Database\Seeders;

use App\Models\ExamenMental;
use Illuminate\Database\Seeder;

class ExamenMentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamenMental::firstOrCreate(
            [
                "clinica_servicio_id"=>1,
                "presentacion_id"=>1,
                "postura_id"=>1,
                "ritmo_id"=>1,
                "tono_id"=>1,
                "articulacion_id"=>1,
                "tiempo_id"=>1,
                "espacio_id"=>1,
                "persona_mental_id"=>1,
                "coordinacion_visomotriz_id"=>1,
            ],[]
        );
    }
}
