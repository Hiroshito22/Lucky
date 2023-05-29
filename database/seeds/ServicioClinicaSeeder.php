<?php

// namespace Database\Seeders;

// use App\Models\ClinicaServicio;
// use App\Models\ServicioClinica;
// use App\Models\ServicioClinica;

use App\Models\ServicioClinica;
use Illuminate\Database\Seeder;

class ServicioClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServicioClinica::firstorCreate([
            'servicio_id'=>6,
            'clinica_id'=>1,
            "estado_registro"=>"A"
        ],[]);
    }
}
