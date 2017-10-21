<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\CarUsage;

class CarUsageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CarUsage::class, 5)->create();
    }
}
