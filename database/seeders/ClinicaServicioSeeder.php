<?php

// namespace Database\Seeders;

use App\Models\ClinicaServicio;
use Illuminate\Database\Seeder;

class ClinicaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $padregeneral=ClinicaServicio::firstOrCreate([
            "servicio_id" => null,
            "clinica_id" => 1,
            "nombre" => "Padre General 1",
            "icono" => null,
            "parent_id" => null,
        ]);
        $padre1=ClinicaServicio::firstOrCreate([
            "servicio_id" => null,
            "clinica_id" => 1,
            "nombre" => "Padre 1",
            "icono" => null,
            "parent_id" => $padregeneral->id,
        ]);
        ClinicaServicio::firstOrCreate([
            "servicio_id" => 1,
            "clinica_id" => 1,
            "nombre" => "Hija 1",
            "icono" => null,
            "parent_id" => $padre1->id,
        ]);
    }
}
