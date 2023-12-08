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
            "foto" => null,
            "cantidad" => 20,
        ]);
        Producto::updateOrCreate([
            "descripcion" => "ventilador 2",
            "foto" => null,
            "cantidad" => 20,
        ]);
        Producto::updateOrCreate([
            "descripcion" => "ventilador 3",
            "foto" => null,
            "cantidad" => 20,
        ]);
    }
}
