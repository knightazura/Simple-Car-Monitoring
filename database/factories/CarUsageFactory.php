<?php

use Faker\Generator as Faker;
use App\Models\CarUsage;
use App\Models\Employee;
use App\Models\Driver;
use App\Models\CarStatus;

$factory->define(CarUsage::class, function (Faker $faker) {
    // Car
    $cars       = CarStatus::where('status', 0)->get();
    $total_cars = count($cars);
    $unique_ci  = $faker->unique()->numberBetween(0, ($total_cars - 1));

    // Employee
    $employees  = Employee::all();
    $total_emp  = count($employees);
    $unique_ei  = $faker->unique()->numberBetween(0, ($total_emp - 1));

    // Driver
    $drivers    = Driver::all();
    $total_dri  = count($drivers);
    $unique_di  = $faker->unique()->numberBetween(0, ($total_dri - 1));

    $randomTime = $faker->date($format = 'Y-m-d', $max = 'now') . " " . $faker->time($format = 'H:i:s', $max = 'now');

    return [
        'nip' => $employees[$unique_ei]->nip,
        'car_plat_number' => $cars[$unique_ci]->car_plat_number,
        'driver_id' => $drivers[$unique_di]->id,
        'total_passengers' => mt_rand(1, 2),
        'destination' => $faker->country,
        'necessity' => $faker->realText(100, 1),
        'desire_time' => $randomTime,
        'estimates_time' => mt_rand(1, 2)
    ];
});
