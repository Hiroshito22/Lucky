<?php

// namespace Database\Seeders;

use App\Models\EnfermedadesSistemicos;
use Illuminate\Database\Seeder;

class EnfermedadesSistemicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnfermedadesSistemicos::firstOrCreate([
            "patologia_id"=>13
        ],[]);
        EnfermedadesSistemicos::firstOrCreate([
            "patologia_id"=>14
        ],[]);
        EnfermedadesSistemicos::firstOrCreate([
            "patologia_id"=>39
        ],[]);
        EnfermedadesSistemicos::firstOrCreate([
            "patologia_id"=>40
        ],[]);
        EnfermedadesSistemicos::firstOrCreate([
            "patologia_id"=>41
        ],[]);
    }
}
