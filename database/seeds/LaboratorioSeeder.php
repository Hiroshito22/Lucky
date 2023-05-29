<?php

// namespace Database\Seeders;

use App\Models\Laboratorio;
use Illuminate\Database\Seeder;

class LaboratorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Laboratorio::firstOrCreate([
            "nombre"=>"Hemograma",
            "bregma_id" => 1,
            "precio_referencial"=>40,
            "precio_mensual"=>100,
            "precio_anual"=>1000,
            "icono"=>"icon 1"
        ],[]);
        Laboratorio::firstOrCreate([
            "nombre"=>"Tiroides",
            "bregma_id" => 1,
            "precio_referencial"=>30,
            "precio_mensual"=>90,
            "precio_anual"=>900,
            "icono"=>"icon 2"
        ],[]);
        Laboratorio::firstOrCreate([
            "nombre"=>"hemograma",
            "bregma_id" => 1,
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
            "icono"=>"icon 3"
        ],[]);
    }
}
