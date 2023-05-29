<?php

use App\Models\TipoTrabajador;
use Illuminate\Database\Seeder;

class TipoTrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoTrabajador::firstOrCreate([
            'descripcion'=>'Postulante'
        ]);
        TipoTrabajador::firstOrCreate([
            'descripcion'=>'Planilla'
        ]);
    }
}
