<?php

use AccesoSeeder as GlobalAccesoSeeder;
use Database\Seeders\AccesoSeeder;
use Database\Seeders\TipoRolSeeder;
use Database\Seeders\UnidadMedidaSeeder;
use Illuminate\Database\Seeder;
use TipoRolSeeder as GlobalTipoRolSeeder;
use UnidadMedidaSeeder as GlobalUnidadMedidaSeeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                $this->call(DepartamentoSeeder::class);
                $this->call(ProvinciaSeeder::class);
                $this->call(DistritoSeeder::class);
                $this->call(UserSeeder::class);
                $this->call(TipoDocumentoSeeder::class);
                $this->call(MarcaSeeder::class);
                $this->call(GlobalAccesoSeeder::class);
                $this->call(RolSeeder::class);
                $this->call(GlobalTipoRolSeeder::class);
                $this->call(GlobalUnidadMedidaSeeder::class);
        }
}
