<?php

namespace Database\Seeders;

// Copyright © 2019 Dxvn, Inc. All rights reserved.

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        App\User::create([
            'name' => 'Tran Ngoc Duc',
            'username' => 'ductn',
            'email' => 'caothu91@gmail.com',
            'password' => Hash::make('Ductn@7691'),
            'role' => 5,
        ]);
    }
}
