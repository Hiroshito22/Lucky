<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EnfermedadEspecificaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = database_path('enfermedad_especifica.sql');
        DB::unprepared(file_get_contents($sql));
    }
}
