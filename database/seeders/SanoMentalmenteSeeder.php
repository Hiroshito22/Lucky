<?php

// namespace Database\Seeders;

use App\Models\SanoMentalmente;
use Illuminate\Database\Seeder;

class SanoMentalmenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SanoMentalmente::firstOrCreate(
            [
                "resultado"=>"Si",
                "estado_registro"=>"A",
            ],[]
        );
        SanoMentalmente::firstOrCreate(
            [
                "resultado"=>"No",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
