<?php

// namespace Database\Seeders;

use App\Models\TipoPerfil;
use Illuminate\Database\Seeder;

class TipoPerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPerfil::firstOrCreate([
            "nombre"=>"Entrada"
        ],[]);
        TipoPerfil::firstOrCreate([
            "nombre"=>"Rutina"
        ],[]);
        TipoPerfil::firstOrCreate([
            "nombre"=>"Salida"
        ],[]);
    }
}
