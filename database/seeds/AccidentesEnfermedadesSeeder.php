<?php

//namespace Database\Seeders;

use App\Models\AccidentesEnfermedades;
use Illuminate\Database\Seeder;

class AccidentesEnfermedadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"No refiere",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Problemas de salud relacionados con una intervención quirúrgica",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Descanso médico por",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Accidente incapacitante, refiere",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Lesiones y/o fracturadas ocurridas en vida cotidiana",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Dificultades psicológicas que no fueron atendidas por especialista",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Problemas de salud crónicos con tratamiento médico",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Problemas de salud crónicos sin tratamiento médico",
                "estado_registro"=>"A",
            ],[]
        );
        AccidentesEnfermedades::firstOrCreate(
            [
                "nombre"=>"Lesiones y/o fracturadas ocurridas en trabajos anteriores",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
