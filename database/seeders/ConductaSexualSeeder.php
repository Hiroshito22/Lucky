<?php

// namespace Database\Seeders;

use App\Models\ConductaSexual;
use Illuminate\Database\Seeder;

class ConductaSexualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConductaSexual::firstOrCreate(
            [
                "nombre"=>"Orientado a su rol de género",
            ],[]
        );
        ConductaSexual::firstOrCreate(
            [
                "nombre"=>"Orientada a su rol de género",
            ],[]
        );
        ConductaSexual::firstOrCreate(
            [
                "nombre"=>"Desorientado(a) y no identificado(a) con su género",
            ],[]
        );
    }
}
