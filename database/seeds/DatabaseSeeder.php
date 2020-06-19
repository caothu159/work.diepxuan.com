<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call( UsersTableSeeder::class );
        $this->call( CarsTableSeeder::class );
        $this->call( SyncTableSeeder::class );
    }
}
