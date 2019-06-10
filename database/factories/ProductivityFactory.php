<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use App\Productivity;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(Productivity::class, function (Faker $faker) {
    return [
        'time'         => $faker->numberBetween(0, 1000000),
        'ns 01593'     => $faker->numberBetween(0, 1000000),
        'no 01593'     => $faker->numberBetween(0, 1000000),
        'thu no 01593' => $faker->numberBetween(0, 1000000),
        'ns 03166'     => $faker->numberBetween(0, 1000000),
        'no 03166'     => $faker->numberBetween(0, 1000000),
        'thu no 03166' => $faker->numberBetween(0, 1000000),
        'ns 05605'     => $faker->numberBetween(0, 1000000),
        'no 05605'     => $faker->numberBetween(0, 1000000),
        'thu no 05605' => $faker->numberBetween(0, 1000000),
    ];
});
