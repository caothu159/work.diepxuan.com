<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use App\Car;
use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "\e[32mSeeding:\e[0m CarsTableSeeder\r\n";

        Car::create(['name' => '05605']);
        Car::create(['name' => '01593']);
        Car::create(['name' => '03166']);
    }
}
