<?php

use Faker\Generator as Faker;
use App\Models\Employee;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'nip' => $faker->unique()->numberBetween($min = 10000, $max = 99999),
        'employee_name' => $faker->name,
        'employee_position' => $faker->jobTitle,
        'division' => $faker->company
    ];
});
