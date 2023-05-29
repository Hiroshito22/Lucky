<?php

use Illuminate\Database\Seeder;
use App\Models\EstadoCivil;
class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoCivil::firstOrCreate(
            [
                "nombre"=>"Soltero(a)"
            ]
        );
        EstadoCivil::firstOrCreate(
            [
                "nombre"=>"Casado(a)"
            ]
        );
        EstadoCivil::firstOrCreate(
            [
                "nombre"=>"Divorciado(a)"
            ]
        );
        EstadoCivil::firstOrCreate(
            [
                "nombre"=>"Viudo(a)"
            ]
        );
    }
}
