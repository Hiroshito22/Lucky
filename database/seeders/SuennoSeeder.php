<?php

// namespace Database\Seeders;

use App\Models\Suenno;
use Illuminate\Database\Seeder;

class SuennoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Suenno::firstOrCreate(
            [
                "nombre"=>"Ciclo REM adecuado",
            ],[]
        );
        Suenno::firstOrCreate(
            [
                "nombre"=>"Variado (hacia el aumento)",
            ],[]
        );
        Suenno::firstOrCreate(
            [
                "nombre"=>"Variado (hacia el disminución)",
            ],[]
        );
        Suenno::firstOrCreate(
            [
                "nombre"=>"insomnio",
            ],[]
        );
        Suenno::firstOrCreate(
            [
                "nombre"=>"Pesadillas Constantes",
            ],[]
        );
        Suenno::firstOrCreate(
            [
                "nombre"=>"Terrores Nocturnos",
            ],[]
        );
        Suenno::firstOrCreate(
            [
                "nombre"=>"Sonambulismo",
            ],[]
        );
        Suenno::firstOrCreate(
            [
                "nombre"=>"Bruxismo",
            ],[]
        );
    }
}
