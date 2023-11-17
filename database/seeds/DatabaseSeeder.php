<?php

use Illuminate\Database\Seeder;
use TipoRolSeeder as GlobalTipoRolSeeder;

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
                $this->call(RolSeeder::class);
                $this->call(EmpresaSeeder::class);
                $this->call(GlobalTipoRolSeeder::class);
        }
}
