<?php

// namespace Database\Seeders;

use App\Models\Examen;
use Illuminate\Database\Seeder;

class ExamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Examen::firstOrCreate([
            "nombre"=>"RX Torax",
            "bregma_id" => 1,
            "precio_referencial"=>40,
            "precio_mensual"=>100,
            "precio_anual"=>1000,
            "icono"=>"icon 1"
        ],[]);
        Examen::firstOrCreate([
            "nombre"=>"RX cervical",
            "bregma_id" => 1,
            "precio_referencial"=>30,
            "precio_mensual"=>90,
            "precio_anual"=>900,
            "icono"=>"icon 2"
        ],[]);
        Examen::firstOrCreate([
            "nombre"=>"RX Craneo",
            "bregma_id" => 1,
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
            "icono"=>"icon 3"
        ],[]);
    }
}
