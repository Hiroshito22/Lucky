<?php

use App\Models\Tiempo;
use Illuminate\Database\Seeder;
use App\Models\TipoTiempo;

class TiempoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //seeders de tipo tiempo
        $tipotiempo1 = TipoTiempo::firstOrCreate(
            [
                "nombre"=>"Semanal",
                "estado_registro"=>"A",
            ]
        );
        
        $tipotiempo2=TipoTiempo::firstOrCreate(
            [
                "nombre"=>"Diario",
                "estado_registro"=>"A",
            ]
        );
        
        $tipotiempo3=TipoTiempo::firstOrCreate(
            [
                "nombre"=>"Anual",
                "estado_registro"=>"A",
            ]
        );
        //seeders de tiempo
        Tiempo::firstOrCreate(
            [
                "tipo_tiempo_id"=>$tipotiempo1->id,
                "cantidad"=>"10",
            ]
        );
        Tiempo::firstOrCreate(
            [
                "tipo_tiempo_id"=>$tipotiempo2->id,
                "cantidad"=>"20",
            ]
        );
        Tiempo::firstOrCreate(
            [
                "tipo_tiempo_id"=>$tipotiempo3->id,
                "cantidad"=>"30",
            ]
        );
    }

}
