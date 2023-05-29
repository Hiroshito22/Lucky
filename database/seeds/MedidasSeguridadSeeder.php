<?php

use Illuminate\Database\Seeder;
use App\Models\MedidaSeguridad;
class MedidasSeguridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedidaSeguridad::updateOrCreate(
            [
                "nombre"=>"Tratamientos",
                "estado_registro"=>"A",
            ]
        );
        MedidaSeguridad::updateOrCreate(
            [
                "nombre"=>"Seguros",
                "estado_registro"=>"A",
            ]
        );
        MedidaSeguridad::updateOrCreate(
            [
                "nombre"=>"Internado",
                "estado_registro"=>"A",
            ]
        );
        
    }
}
