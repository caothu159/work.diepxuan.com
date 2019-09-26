<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "\e[32mSeeding:\e[0m UsersTableSeeder\r\n";

        // Seed admin
        User::updateOrCreate( [
            'username' => 'admin',
            'email'    => 'caothu91@gmail.com',
        ], [
            'name'     => 'Administrator',
            'password' => Hash::make( 'bg2tob699' ),
            'role'     => 5,
        ] );

        // Seed user
        User::updateOrCreate( [
            'username' => 'caothu91',
            'email'    => 'ductn@diepxuan.com',
        ], [
            'name'        => 'Trần Ngọc Đức',
            'password'    => Hash::make( 'bg2tob699' ),
            'salary_name' => 'caothu91',
        ] );
        User::updateOrCreate( [
            'username' => 'thuykt',
            'email'    => 'thuy@diepxuan.com',
        ], [
            'name'        => 'Trần Thị Lệ Thủy',
            'password'    => Hash::make( 'thuy@123' ),
            'salary_name' => 'Chi Thuy',
        ] );
    }
}
