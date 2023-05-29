<?php

// namespace Database\Seeders;

use App\Models\Apetito;
use Illuminate\Database\Seeder;

class ApetitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Apetito::firstOrCreate(
            [
                "nombre"=>"Adecuado",
            ],[]
        );
        Apetito::firstOrCreate(
            [
                "nombre"=>"Variable",
            ],[]
        );
        Apetito::firstOrCreate(
            [
                "nombre"=>"Ausente",
            ],[]
        );
        Apetito::firstOrCreate(
            [
                "nombre"=>"Excesivo",
            ],[]
        );
    }
}
