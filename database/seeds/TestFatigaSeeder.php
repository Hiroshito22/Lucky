<?php

// namespace Database\Seeders;

use App\Models\TestFatiga;
use Illuminate\Database\Seeder;

class TestFatigaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestFatiga::firstOrCreate(
            [
                "resultado"=>"Normal",
                "estado_registro"=>"A",
            ],[]
        );
        TestFatiga::firstOrCreate(
            [
                "resultado"=>"Anormal",
                "estado_registro"=>"A",
            ],[]
        );
        TestFatiga::firstOrCreate(
            [
                "resultado"=>"No realizada",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
