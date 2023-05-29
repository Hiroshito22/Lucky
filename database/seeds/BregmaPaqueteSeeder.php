<?php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BregmaPaquete;
use App\Models\BregmaPaqueteArea;
use App\Models\BregmaPaqueteExamen;
use App\Models\BregmaPaqueteLaboratorio;

class BregmaPaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bregma_paquete = BregmaPaquete::firstOrCreate([
            "bregma_id" => 1,
            "bregma_servicio_id" => null,
            "icono" => "icono 1",
            "nombre" => "paquete 1",
            "precio_mensual" => 810,
            "precio_anual" => 8100,
        ]);
        BregmaPaqueteArea::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "area_medica_id" => 1
        ]);
        BregmaPaqueteArea::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "area_medica_id" => 2
        ]);
        BregmaPaqueteArea::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "area_medica_id" => 3
        ]);

        BregmaPaqueteExamen::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "examen_id" => 1
        ]);
        BregmaPaqueteExamen::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "examen_id" => 2
        ]);
        BregmaPaqueteExamen::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "examen_id" => 3
        ]);

        BregmaPaqueteLaboratorio::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "laboratorio_id" => 1
        ]);
        BregmaPaqueteLaboratorio::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "laboratorio_id" => 2
        ]);
        BregmaPaqueteLaboratorio::firstOrCreate([
            "bregma_paquete_id" => $bregma_paquete->id,
            "laboratorio_id" => 3
        ]);
    }
}