<?php

use App\Models\Religion;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Religion::updateOrCreate(
            [
                "descripcion"=>"Catolica",
                "estado_registro"=>"A",
            ]
        );
        Religion::updateOrCreate(
            [
                "descripcion"=>"Adventista",
                "estado_registro"=>"A",
            ]
        );
        Religion::updateOrCreate(
            [
                "descripcion"=>"Musulmán",
                "estado_registro"=>"A",
            ]
        );
        Religion::updateOrCreate(
            [
                "descripcion"=>"Judio",
                "estado_registro"=>"A",
            ]
        );
        Religion::updateOrCreate(
            [
                "descripcion"=>"Evangelico",
                "estado_registro"=>"A",
            ]
        );
        Religion::updateOrCreate(
            [
                "descripcion"=>"Cristiano",
                "estado_registro"=>"A",
            ]
        );
        Religion::updateOrCreate(
            [
                "descripcion"=>"Luterano",
                "estado_registro"=>"A",
            ]
        );
        Religion::updateOrCreate(
            [
                "descripcion"=>"Otros",
                "estado_registro"=>"A",
            ]
        );
    }
}
