<?php

use Illuminate\Database\Seeder;
use App\Models\Triaje\Pariente;
class ParienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pariente::firstOrCreate([
            "pariente"=>"Padre",
        ],[]);
        Pariente::firstOrCreate([
            "pariente"=>"Madre",
        ],[]);
        Pariente::firstOrCreate([
            "pariente"=>"Hermanos",
        ],[]);
        Pariente::firstOrCreate([
            "pariente"=>"Abuelo Paterno",
        ],[]);
        Pariente::firstOrCreate([
            "pariente"=>"Abuelo Materno",
        ],[]);
    }
}
