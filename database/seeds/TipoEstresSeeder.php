<?php

// namespace Database\Seeders;

use App\Models\TipoEstres;
use Illuminate\Database\Seeder;

class TipoEstresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEstres::firstOrCreate(
            [
                "resultado"=>"Normal",
                "estado_registro"=>"A",
            ],[]
        );
        TipoEstres::firstOrCreate(
            [
                "resultado"=>"Anormal",
                "estado_registro"=>"A",
            ],[]
        );
        TipoEstres::firstOrCreate(
            [
                "resultado"=>"No realizada",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
