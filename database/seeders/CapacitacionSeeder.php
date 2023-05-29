<?php

// namespace Database\Seeders;

use App\Models\Capacitacion;
use Illuminate\Database\Seeder;

class CapacitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Capacitacion::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"prueba example 1",
            "precio_referencial"=>40,
            "precio_mensual"=>100,
            "precio_anual"=>1000,
            "icono"=>"icon 1"
        ],[]);
        Capacitacion::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"prueba example 2",
            "precio_referencial"=>30,
            "precio_mensual"=>90,
            "precio_anual"=>900,
            "icono"=>"icon 2"
        ],[]);
        Capacitacion::firstOrCreate([
            "bregma_id" => 1,
            "nombre"=>"prueba example 3",
            "precio_referencial"=>20,
            "precio_mensual"=>80,
            "precio_anual"=>800,
            "icono"=>"icon 3"
        ],[]);
    }
}
