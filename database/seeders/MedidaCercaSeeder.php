<?php

// namespace Database\Seeders;

use App\Models\MedidaCerca;
use Illuminate\Database\Seeder;

class MedidaCercaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedidaCerca::firstOrCreate([
            "medida"=>"20/10"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/13"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/15"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/16"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/20"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/25"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/30"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/32"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/40"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/50"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/60"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/63"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/70"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/80"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/100"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/125"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/150"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/160"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/200"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/250"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/320"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/400"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/500"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"20/800"
        ],[]);
        MedidaCerca::firstOrCreate([
            "medida"=>"Ausente"
        ],[]);
    }
}
