<?php

use Illuminate\Database\Seeder;
use App\Models\TipoEvaluacion;
class TipoEvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEvaluacion::firstOrCreate(
            [
                "nombre"=>"Pre Ocupacional",
                "estado_registro"=>"A"
            ]
        );
        TipoEvaluacion::firstOrCreate(
            [
                "nombre"=>"Periódica",
                "estado_registro"=>"A"
            ]
        );
        TipoEvaluacion::firstOrCreate(
            [
                "nombre"=>"Retiro",
                "estado_registro"=>"A"
            ]
        );
        TipoEvaluacion::firstOrCreate(
            [
                "nombre"=>"Otros",
                "estado_registro"=>"A"
            ]
        );
    }
}
