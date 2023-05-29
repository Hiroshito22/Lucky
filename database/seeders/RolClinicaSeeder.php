<?php

use Illuminate\Database\Seeder;
use App\Models\Clinica\RolClinica;
class RolClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolClinica::updateOrCreate(
            [
                'nombre'=>"Medico de la Clinica 1",
                'clinica_id'=>1,
            ],
            [
                'estado_registro'=>"A"
            ]);
    }
}
