<?php

// namespace Database\Seeders;

use App\Models\Afectividad;
use App\Models\Apetito;
use App\Models\ConductaSexual;
use App\Models\Inteligencia;
use App\Models\LucidoAtento;
use App\Models\Memoria;
use App\Models\Pensamiento;
use App\Models\Persepcion;
use App\Models\Personalidad;
use App\Models\Sueño;
use Illuminate\Database\Seeder;

class LucidoAtentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LucidoAtento::firstOrCreate(
            [
                "nombre"=>"Selectivo y sostenido",
            ],[]
        );
        LucidoAtento::firstOrCreate(
            [
                "nombre"=>"Selectivo, sostenido y distribuido",
            ],[]
        );
        LucidoAtento::firstOrCreate(
            [
                "nombre"=>"Voluntaria",
            ],[]
        );
        LucidoAtento::firstOrCreate(
            [
                "nombre"=>"Involuntaria",
            ],[]
        );
        LucidoAtento::firstOrCreate(
            [
                "nombre"=>"Dividida",
            ],[]
        );
    }
}
