<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class, 25)->create();
    }
}
