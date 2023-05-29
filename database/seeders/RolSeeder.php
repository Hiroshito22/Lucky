<?php

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = Rol::firstOrCreate(
            [
                "nombre" => "Administrador Bregma",
                "tipo_acceso" => 1,
            ],
            [
                "estado_registro" => "SU",
            ]
        );
        $rol = Rol::firstOrCreate(
            [
                "nombre" => "Administrador Hospital",
                "tipo_acceso" => 2,

            ],
            [
                "estado_registro" => "AD"
            ]
        );
        $rol = Rol::firstOrCreate(
            [
                "nombre" => "Administrador Empresa",
                "tipo_acceso" => 3,
            ],
            [
                "estado_registro" => "AD",
            ]
        );
        $rol = Rol::firstOrCreate(
            [
                "nombre" => "Administrador Clinica",
                "tipo_acceso" => 4,
            ],
            [
                "estado_registro" => "AD",
            ]
        );
        Rol::firstOrCreate(
            [
                "nombre" => "Transportista",
                "tipo_acceso" => 5,
            ],
            [
                "estado_registro" => "AD",
            ]
        );
    }
}
