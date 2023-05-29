<?php

// namespace Database\Seeders;

use App\Models\AreaMedica;
use Illuminate\Database\Seeder;

class AreaMedicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"Triaje",
            "precio_referencial"=>40,
            "precio_mensual"=>100,
            "precio_anual"=>1000,
        ],[]);
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"Psicología",
            "precio_referencial"=>30,
            "precio_mensual"=>90,
            "precio_anual"=>900,
        ],[]);
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"EKG",
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
        ],[]);
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"Oftalmología",
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800
        ],[]);
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"Audiometría",
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
        ],[]);
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"Radiología",
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
        ],[]);
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"Laboratorio",
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
        ],[]);
        AreaMedica::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"Medicina General",
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
        ],[]);
    }
}
