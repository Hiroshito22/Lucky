<?php

use Illuminate\Database\Seeder;
use App\Models\TipoPatologia;
class TipoPatologiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPatologia::firstOrCreate([
            "nombre"=>"Triaje"
        ],[
            "estado_registro"=>"A"
        ]);
        TipoPatologia::firstOrCreate([
            "nombre"=>"Oftalmología"
        ],[
            "estado_registro"=>"A"
        ]);
    }
}
