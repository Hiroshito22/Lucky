<?php

//namespace Database\Seeders;

use App\Models\PrincipalRiesgo;
use Illuminate\Database\Seeder;

class PrincipalRiesgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"No refiere",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Exposición a caída a desnivel, ruidos",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Choque, malas maniobras",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Caída de altura, atrapamientos",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Accidentes de tránsito",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Mutilaciones, caídas, pérdida de la vida",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Quemaduras, fracturas, corte",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"No estar concentrado en el trabajo",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Mala postura, tensión psicológica, estar triste o preocupado",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"No dormir sus horas necesarias",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"No realizar procedimientos de seguridad del área",
                "estado_registro"=>"A",
            ],[]
        );
        PrincipalRiesgo::firstOrCreate(
            [
                "nombre"=>"Ingerir bebidas alcohólicas",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
