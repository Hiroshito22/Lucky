<?php

//namespace Database\Seeders;


use App\Models\EvaluacionPsicopatologica;
use Illuminate\Database\Seeder;


class EvaluacionPsicopatologicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EvaluacionPsicopatologica::firstOrCreate(
            [
                "resultado"=>"Si",
                "estado_registro"=>"A",
            ],[]
        );
        EvaluacionPsicopatologica::firstOrCreate(
            [
                "resultado"=>"No",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
