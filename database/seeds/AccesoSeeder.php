<?php

//namespace Database\Seeders;

use App\Models\Acceso;
use Illuminate\Database\Seeder;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acceso::updateOrCreate([
            "url" => "1",
            "icon" => "1",
            "label" => "Administrador 1",
            "parent_id" => 0,
            "estado_registro" => "A",
        ]);
        Acceso::updateOrCreate([
            "url" => "2",
            "icon" => "2",
            "label" => "Administrador 2",
            "parent_id" => 0,
            "estado_registro" => "A",
        ]);
        Acceso::updateOrCreate([
            "url" => "3",
            "icon" => "3",
            "label" => "Administrador 3",
            "parent_id" => 0,
            "estado_registro" => "A",
        ]);
    }
}
