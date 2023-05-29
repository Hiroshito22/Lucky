<?php

use App\Models\TipoVehiculo;
use Illuminate\Database\Seeder;

class TipoVehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoVehiculo::create(
            [
                'nombre' => 'Auto'
            ]
        );
        TipoVehiculo::create(
            [
                'nombre' => 'Moto'
            ]
        );
        TipoVehiculo::create(
            [
                'nombre' => 'Camioneta'
            ]
        );
        TipoVehiculo::create(
            [
                'nombre' => 'Minivan'
            ]
        );
        TipoVehiculo::create(
            [
                'nombre' => 'Custer'
            ]
        );
    }
}
