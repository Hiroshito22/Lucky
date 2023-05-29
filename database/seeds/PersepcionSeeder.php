<?php

// namespace Database\Seeders;

// use App\Models\Persepcion;

use App\Models\Persepcion;
use Illuminate\Database\Seeder;

class PersepcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Persepcion::firstOrCreate(
            [
                "nombre"=>"Multisensorial",
                "estado_registro"=>"A"
            ],[]
        );

        Persepcion::firstOrCreate(
            [
                "nombre"=>"Visual",
                "estado_registro"=>"A"
            ],[]
        );

        Persepcion::firstOrCreate(
            [
                "nombre"=>"Espacial",
                "estado_registro"=>"A"
            ],[]
        );
        
        Persepcion::firstOrCreate(
            [
                "nombre"=>"Cenestécia",
                "estado_registro"=>"A"
            ],[]
        );

        Persepcion::firstOrCreate(
            [
                "nombre"=>"Kinestécia",
                "estado_registro"=>"A"
            ],[]
        );
    }
}
