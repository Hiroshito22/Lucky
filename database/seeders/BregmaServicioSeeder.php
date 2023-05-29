<?php

//namespace Database\Seeders;

use App\Models\BregmaServicio;
use Illuminate\Database\Seeder;

class BregmaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $padregeneral=BregmaServicio::firstOrCreate([
            "bregma_id" => 1,
            "icono" => null,
            "nombre" => "Bregma Servicio General",
            "descripcion" => "Padre general",
            "parent_id" => null,
        ]);
        $padre=BregmaServicio::firstOrCreate([
            "bregma_id" => 1,
            "icono" => null,
            "nombre" => "Bregma Servicio Padre",
            "descripcion" => "Padre 1",
            "parent_id" => $padregeneral->id,
        ]);
        $hijo = BregmaServicio::firstOrCreate([
            "bregma_id" => 1,
            "icono" => null,
            "nombre" => "Bregma Servicio Hijo 1",
            "descripcion" => "hijo 1",
            "parent_id" => $padre->id,
        ]);
        BregmaServicio::firstOrCreate([
            "bregma_id" => 1,
            "icono" => null,
            "nombre" => "Bregma Servicio Hijo 1.1",
            "descripcion" => "hijo 1",
            "parent_id" => $hijo->id,
        ]);
    }
}
