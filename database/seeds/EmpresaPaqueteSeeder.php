<?php

use Illuminate\Database\Seeder;
use App\Models\EmpresaPaquete;
class EmpresaPaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mispaquetes = EmpresaPaquete::firstOrCreate([
            "empresa_id"=>1,
            "paquete_id"=>1,
            "precio"=>200,
        ]);
        $mispaquetes = EmpresaPaquete::firstOrCreate([
            "empresa_id"=>1,
            "paquete_id"=>2,
            "precio"=>200,
        ]);
    }
}
