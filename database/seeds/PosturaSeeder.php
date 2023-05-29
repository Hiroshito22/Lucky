<?php

use Illuminate\Database\Seeder;
use App\Models\Postura;
class PosturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Postura::updateOrCreate(
            [
                "nombre"=>"Erguida",
                "estado_registro"=>"A",
            ]
        );
        Postura::updateOrCreate(
            [
                "nombre"=>"Encorvada",
                "estado_registro"=>"A",
            ]
        );
        
    }
}
