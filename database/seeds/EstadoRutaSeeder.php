<?php

//namespace Database\Seeders;

use App\Models\EstadoRuta;
use Illuminate\Database\Seeder;

class EstadoRutaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoRuta ::firstOrCreate(
            [
                "nombre"=>"No atendido",
                "estado_registro"=>"A",
            ],
            []
        );
        EstadoRuta ::firstOrCreate(
            [
                "nombre"=>"En espera",
                "estado_registro"=>"A",
            ],
            []
        );
        EstadoRuta ::firstOrCreate(
            [
                "nombre"=>"Atendido",
                "estado_registro"=>"A",
            ],
            []
        );
        EstadoRuta ::firstOrCreate(
            [
                "nombre"=>"Falta de Atencion",
                "estado_registro"=>"A",
            ],
            []
        );
    }
}
