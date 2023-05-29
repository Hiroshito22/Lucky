<?php

//namespace Database\Seeders;

use App\Models\MedidaSeguridad;
use Illuminate\Database\Seeder;

class MedidaSeguridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedidaSeguridad::firstOrCreate(
            [
                "nombre"=>"No refiere",
                "estado_registro"=>"A",
            ],[]
        );
        MedidaSeguridad::firstOrCreate(
            [
                "nombre"=>"Uso correcto de los EPPS",
                "estado_registro"=>"A",
            ],[]
        );
        MedidaSeguridad::firstOrCreate(
            [
                "nombre"=>"Estar atento y concentrado en el trabajo a realizar",
                "estado_registro"=>"A",
            ],[]
        );
        MedidaSeguridad::firstOrCreate(
            [
                "nombre"=>"Seguir procedimientos",
                "estado_registro"=>"A",
            ],[]
        );
        MedidaSeguridad::firstOrCreate(
            [
                "nombre"=>"Manejo defensivo, realizar check list",
                "estado_registro"=>"A",
            ],[]
        );
        MedidaSeguridad::firstOrCreate(
            [
                "nombre"=>"Recibir charlas de inducción y seguridad",
                "estado_registro"=>"A",
            ],[]
        );
        MedidaSeguridad::firstOrCreate(
            [
                "nombre"=>"Revisar el área de seguridad",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
