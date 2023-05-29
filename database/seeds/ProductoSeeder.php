<?php

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
            'nombre'=>'producto1',
            'precio'=>'10'
        ]);
        Producto::updateOrCreate([
            'nombre'=>'producto2',
            'precio'=>'20'
        ]);
        Producto::updateOrCreate([
            'nombre'=>'producto3',
            'precio'=>'30'
        ]);
        Producto::updateOrCreate([
            'nombre'=>'producto4',
            'precio'=>'40'
        ]);
        Producto::updateOrCreate([
            'nombre'=>'producto5',
            'precio'=>'50'
        ]);
    }
}
