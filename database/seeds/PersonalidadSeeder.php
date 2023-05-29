<?php

// namespace Database\Seeders;

use App\Models\Personalidad;
use Illuminate\Database\Seeder;

class PersonalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Tendencia a la introversión",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Tendencia a la extroversión",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del alentador",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del realizador",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del perfeccionista",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del creativo",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del objetivo",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del persuasivo",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del promotor",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del consejero",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del agente",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del evaluador",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del resolutivo",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón profesional",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del investigador",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del orientado a resultados",
            ],[]
        );
        Personalidad::firstOrCreate(
            [
                "nombre"=>"Patrón del especialista",
            ],[]
        );
    }
}
