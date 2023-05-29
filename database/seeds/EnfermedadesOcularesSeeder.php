<?php

// namespace Database\Seeders;

use App\Models\EnfermedadesOculares;
use Illuminate\Database\Seeder;

class EnfermedadesOcularesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnfermedadesOculares::firstOrCreate([
            "patologia_id"=>13
        ],[]);
        EnfermedadesOculares::firstOrCreate([
            "patologia_id"=>14
        ],[]);
        EnfermedadesOculares::firstOrCreate([
            "patologia_id"=>39
        ],[]);
        EnfermedadesOculares::firstOrCreate([
            "patologia_id"=>40
        ],[]);
        EnfermedadesOculares::firstOrCreate([
            "patologia_id"=>41
        ],[]);
    }
}
