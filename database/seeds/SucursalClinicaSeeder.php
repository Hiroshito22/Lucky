<?php

use Illuminate\Database\Seeder;
use App\Models\Clinica\SucursalClinica;
class SucursalClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SucursalClinica::updateOrCreate(
            [
                'nombre_sucursal'=>"Sucursal 1 para la Clinica 1",
                'clinica_id'=>1,
                'direccion_sucursal'=>"Miraflores - Lima"
            ],
            [
                'estado_registro'=>"A"
            ]);
    }
}
