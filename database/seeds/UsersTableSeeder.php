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
        if ( User::where( 'email', '=', 'caothu91@gmail.com' )->first() === null ) {
            User::create( [
                'name'     => 'Administrator',
                'username' => 'admin',
                'email'    => 'caothu91@gmail.com',
                'password' => Hash::make( 'bg2tob699' ),
                'role'     => 5,
            ] );
        }

        // Seed user
        if ( User::where( 'email', '=', 'ductn@diepxuan.com' )->first() === null ) {
            User::create( [
                'name'        => 'Trần Ngọc Đức',
                'username'    => 'caothu91',
                'email'       => 'ductn@diepxuan.com',
                'password'    => Hash::make( 'bg2tob699' ),
                'salary_name' => 'caothu91',
            ] );
        }
        if ( User::where( 'email', '=', 'thuy@diepxuan.com' )->first() === null ) {
            User::create( [
                'name'        => 'Hồ Thị Thu Thủy',
                'username'    => 'thuykt',
                'email'       => 'thuy@diepxuan.com',
                'password'    => Hash::make( 'thuy@123' ),
                'salary_name' => 'Chi Thuy',
            ] );
        }
    }
}
