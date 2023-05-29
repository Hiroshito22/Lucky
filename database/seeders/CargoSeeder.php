<?php

use App\Models\Cargo;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cargo::firstOrCreate([
            'nombre'=>'Administrativo'
        ]);
        Cargo::firstOrCreate([
            'nombre'=>'Operario'
        ]);
    }
}
