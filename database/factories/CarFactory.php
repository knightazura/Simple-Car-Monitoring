<?php

use Faker\Generator as Faker;
use App\Models\Car;

$factory->define(Car::class, function (Faker $faker) {

    $numbers = $faker->unique()->numberBetween($min = 1, $max = 9000); // 8567
    $last_phrase = $faker->stateAbbr;
    $plat_number = "DD" . $numbers . $last_phrase;

    return [
        'plat_number' => $plat_number,
        'car_name' => $faker->cityPrefix
    ];
});
