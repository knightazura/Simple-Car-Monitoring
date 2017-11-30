<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         *  Dummy trial development
         *  $this->call(CarTableSeeder::class);
         *  $this->call(EmployeeTableSeeder::class);
         *  $this->call(DriverTableSeeder::class);
         *  $this->call(CarUsageTableSeeder::class);
         *  $this->call(DriverCompaniesSeeder::class);
         */
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
    }
}
