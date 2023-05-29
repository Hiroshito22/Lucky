<?php

use App\Models\Correctores;
use Illuminate\Database\Seeder;

class CorrectoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Correctores::firstOrCreate(
            [
                "respuesta"=>"Si",
                "estado_registro"=>"A",
            ],[]
        );
        Correctores::firstOrCreate(
            [
                "respuesta"=>"No",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
