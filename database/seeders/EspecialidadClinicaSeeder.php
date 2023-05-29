<?php

use App\Models\Clinica\EspecialidadClinica;
use Illuminate\Database\Seeder;
class EspecialidadClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EspecialidadClinica::updateOrCreate(
            [
                'nombre'=>"Especialidad de la Clinica 1",
                'clinica_id'=>1,
            ],
            [
                'estado_registro'=>"A"
            ]);
    }
}
