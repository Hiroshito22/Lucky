<?php

// namespace Database\Seeders;

use App\Models\EvaluacionEmocional;
use Illuminate\Database\Seeder;

class EvaluacionEmocionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EvaluacionEmocional::firstOrCreate(
            [
                "resultado"=>"Si",
                "estado_registro"=>"A",
            ],[]
        );
        EvaluacionEmocional::firstOrCreate(
            [
                "resultado"=>"No",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
