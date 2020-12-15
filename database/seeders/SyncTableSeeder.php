<?php

namespace Database\Seeders;

// Copyright © 2019 Dxvn, Inc. All rights reserved.

use App\Model\Sync;
use Illuminate\Database\Seeder;

class SyncTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Sync::updateOrCreate([
            'from' => '001',
            'to' => '002',
            'type' => 'ma_cty',
        ], [
            'from' => '001',
            'to' => '002',
            'type' => 'ma_cty',
        ]);

        Sync::updateOrCreate([
            'from' => '0TRANNGOCDUC',
            'to' => 'CONGTY',
            'type' => 'ma_kh',
        ], [
            'from' => '0TRANNGOCDUC',
            'to' => 'CONGTY',
            'type' => 'ma_kh',
        ]);
    }
}
