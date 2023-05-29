<?php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoCliente;

class TipoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCliente::updateOrCreate(
            [
                "nombre"=>"clinica corporativa",
                "estado_registro"=>"A"
            ],
            [

            ]
        );
        TipoCliente::updateOrCreate(
            [
                "nombre"=>"consultora",
                "estado_registro"=>"A"
            ],
            [

            ]
        );
        TipoCliente::updateOrCreate(
            [
                "nombre"=>"particular",
                "estado_registro"=>"A"
            ],
            [

            ]
        );
        TipoCliente::updateOrCreate(
            [
                "nombre"=>"empresa",
                "estado_registro"=>"A"
            ],
            [

            ]
        );
    }
}
