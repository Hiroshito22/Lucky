<?php

// namespace Database\Seeders;

use App\Models\Pensamiento;
use Illuminate\Database\Seeder;

class PensamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pensamiento::firstOrCreate(
            [
                "nombre"=>"Racional",
            ],[]
        );
        Pensamiento::firstOrCreate(
            [
                "nombre"=>"Racional e inductivo",
            ],[]
        );
        Pensamiento::firstOrCreate(
            [
                "nombre"=>"Racional y deductivo",
            ],[]
        );
        Pensamiento::firstOrCreate(
            [
                "nombre"=>"Concreto",
            ],[]
        );
        Pensamiento::firstOrCreate(
            [
                "nombre"=>"Analítico",
            ],[]
        );
    }
}
