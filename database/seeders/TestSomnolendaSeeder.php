<?php

// namespace Database\Seeders;

use App\Models\TestSomnolenda;
use Illuminate\Database\Seeder;

class TestSomnolendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestSomnolenda::firstOrCreate(
            [
                "resultado"=>"Normal",
                "estado_registro"=>"A",
            ],[]
        );
        TestSomnolenda::firstOrCreate(
            [
                "resultado"=>"Anormal",
                "estado_registro"=>"A",
            ],[]
        );
        TestSomnolenda::firstOrCreate(
            [
                "resultado"=>"No realizada",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
