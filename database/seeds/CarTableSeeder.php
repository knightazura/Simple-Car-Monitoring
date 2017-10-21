<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Car;

class CarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Car::class, 50)->create()
        ->each(function ($car) {
          DB::table('car_statuses')->insert([
            'car_plat_number' => $car->plat_number,
            'status' => mt_rand(0, 3)
          ]);
        });
    }
}
