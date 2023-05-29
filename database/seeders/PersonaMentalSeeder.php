<?php

//namespace Database\Seeders;

use App\Models\PersonaMental;
use Illuminate\Database\Seeder;

class PersonaMentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PersonaMental::firstorCreate(
            [
                "nombre" => "Orientado"
            ]
        );
        PersonaMental::firstorCreate(
            [
                "nombre" => "Desorientado"
            ]
        );
    }
}
