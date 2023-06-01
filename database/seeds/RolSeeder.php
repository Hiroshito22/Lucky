<?php

//namespace Database\Seeders;

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
        Rol::updateOrCreate([
            "nombre" => "Administrador Gerente",
            "acceso_id" => 1,
            "estado_registro" => "A"
        ]);
        Rol::updateOrCreate([
            "nombre" => "Administrador Trabajador",
            "acceso_id" => 2,
            "estado_registro" => "A"
        ]);
        Rol::updateOrCreate([
            "nombre" => "Administrador Cliente",
            "acceso_id" => 3,
            "estado_registro" => "A"
        ]);
    }
}
