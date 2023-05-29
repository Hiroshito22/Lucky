<?php

use App\Models\Conductor;
use Illuminate\Database\Seeder;

class ConductorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conductor::firstOrCreate(
            [
                "respuesta"=>"Si",
                "estado_registro"=>"A",
            ],[]
        );
        Conductor::firstOrCreate(
            [
                "respuesta"=>"No",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
