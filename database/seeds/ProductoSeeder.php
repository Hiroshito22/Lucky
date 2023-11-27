<?php

//namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::updateOrCreate([
            "descripcion" => "ventilador 1",
            "marca_id" => 1,
            "empresa_id" => 1,
            "foto" => null,
            "cantidad" => 20,
        ]);
        Producto::updateOrCreate([
            "descripcion" => "ventilador 2",
            "marca_id" => 1,
            "empresa_id" => 1,
            "foto" => null,
            "cantidad" => 20,
        ]);
        Producto::updateOrCreate([
            "descripcion" => "ventilador 3",
            "marca_id" => 2,
            "empresa_id" => 1,
            "foto" => null,
            "cantidad" => 20,
        ]);
    }
}
