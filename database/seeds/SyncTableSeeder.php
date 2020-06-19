<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use App\Model\Sync;
use Illuminate\Database\Seeder;

class SyncTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Sync::updateOrCreate( [
            'from' => '001',
            'to'   => '002',
            'type' => 'ma_cty',
        ], [
            'from' => '001',
            'to'   => '002',
            'type' => 'ma_cty',
        ] );
    }
}
