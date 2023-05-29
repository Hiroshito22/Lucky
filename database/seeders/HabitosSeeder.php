<?php

//namespace Database\Seeders;

use App\Models\Habitos;
use Illuminate\Database\Seeder;

class HabitosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Habitos::firstOrCreate(
            [
                "nombre"=>"Toma bebidas alcohólicas (botellas de cerveza aproximadamente) en compromisos sociales y fuma aproximadamente cigarros en su tiempo libre",
                "estado_registro"=>"A",
            ],[]
        );
    }
}
