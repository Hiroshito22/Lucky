<?php

// namespace Database\Seeders;

use App\Models\MedidaLejos;
use Illuminate\Database\Seeder;

class MedidaLejosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedidaLejos::firstOrCreate([
            "medida"=>"20/10"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/13"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/15"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/16"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/20"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/25"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/30"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/32"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/40"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/50"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/60"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/63"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/70"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/80"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/100"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/125"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/150"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/160"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/200"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/250"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/320"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/400"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/500"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"20/800"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"CD"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"PL"
        ],[]);
        MedidaLejos::firstOrCreate([
            "medida"=>"Ausente"
        ],[]);
    }
}
