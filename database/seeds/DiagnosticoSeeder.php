<?php

use Illuminate\Database\Seeder;
use App\Models\Diagnostico;
class DiagnosticoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>1,
            //'servicio_id',
            'enfermedad_id'=>1,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>1,
            "area_id"=>1,
            'superarea_id'=>1
        ],[]);
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>2,
            //'servicio_id',
            'enfermedad_id'=>1,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>1,
            "area_id"=>1,
            'superarea_id'=>1
        ],[]);
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>3,
            //'servicio_id',
            'enfermedad_id'=>1,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>1,
            "area_id"=>1,
            'superarea_id'=>1
        ],[]);
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>3,
            //'servicio_id',
            'enfermedad_id'=>1,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>2,
            "area_id"=>1,
            'superarea_id'=>1
        ],[]);
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>4,
            //'servicio_id',
            'enfermedad_id'=>2,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>1,
            "area_id"=>1,
            'superarea_id'=>1
        ],[]);
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>3,
            //'servicio_id',
            'enfermedad_id'=>1,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>2,
            "area_id"=>1,
            'superarea_id'=>1
        ],[]);
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>3,
            //'servicio_id',
            'enfermedad_id'=>1,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>1,
            "area_id"=>1,
            'superarea_id'=>1
        ],[]);
        $diagnostico= Diagnostico::firstOrCreate([
            'hc_trabajador_id'=>3,
            //'servicio_id',
            'enfermedad_id'=>1,
            'enfermedad_general_id'=>1,
            'enfermedad_especifica_id'=>1,
            'estado_registro'=>"A",
            'subarea_id'=>3,
            "area_id"=>2,
            'superarea_id'=>1
        ],[]);
    }
}
