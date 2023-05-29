<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                //superadmin
                
                $this->call(DepartamentoSeeder::class);
                $this->call(ProvinciaSeeder::class);
                $this->call(DistritoSeeder::class);
                $this->call(UserSeeder::class);
        }
}
