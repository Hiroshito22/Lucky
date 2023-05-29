<?php

// namespace Database\Seeders;

use App\Models\EvaluacionOrganica;
use Illuminate\Database\Seeder;

class EvaluacionOrganicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EvaluacionOrganica::firstOrCreate(
            [
                "resultado"=>"Si",
                "estado_registro"=>"A",
            ],[]
        );
        EvaluacionOrganica::firstOrCreate(
            [
                "resultado"=>"No",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
