<?php

// namespace Database\Seeders;

use App\Models\StereoFlyTest;
use Illuminate\Database\Seeder;

class StereoFlyTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StereoFlyTest::firstOrCreate([
            "nombre" => "Normal",
        ]);
        StereoFlyTest::firstOrCreate([
            "nombre" => "Anormal",
        ]);
        StereoFlyTest::firstOrCreate([
            "nombre" => "59 MINS",
        ]);
        StereoFlyTest::firstOrCreate([
            "nombre" => "No percibe",
        ]);
        StereoFlyTest::firstOrCreate([
            "nombre" => "No corresponde",
        ]);
    }
}
