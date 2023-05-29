<?php

// namespace Database\Seeders;

use App\Models\Rubro;
use Illuminate\Database\Seeder;

class RubroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rubro::firstOrCreate([
            "nombre"=>"Option 1"
        ],[]);
        Rubro::firstOrCreate([
            "nombre"=>"Option 2"
        ],[]);
        Rubro::firstOrCreate([
            "nombre"=>"Option 3"
        ],[]);
    }
}
