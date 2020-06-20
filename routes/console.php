<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command( 'inspire', function () {
    $this->comment( Inspiring::quote() );
} )->describe( 'Display an inspiring quote' );

Artisan::command( 'dongbo:dmnhsp', function () {
    \App\Model\Work\Nhomsanpham::sync();
} )->describe( 'dong bo nhom san pham' );

Artisan::command( 'dongbo:dmsp', function () {
    \App\Model\Work\Sanpham::sync();
} )->describe( 'dong bo san pham' );
