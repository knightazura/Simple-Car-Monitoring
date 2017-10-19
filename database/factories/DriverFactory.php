<?php

use Faker\Generator as Faker;
use App\Models\Driver;

$factory->define(Driver::class, function (Faker $faker) {
    return [
        'driver_name' => $faker->name,
        'company' => $faker->company
    ];
});
