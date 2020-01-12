<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Auth::routes( [
    'register' => false,
] );

Route::domain( 'luong.diepxuan.com' )->group( function () {
    Route::get( '/', 'Salary\HomeController@index' )->name( 'home' );
    Route::get( 'home', 'Salary\HomeController@index' );

    Route::post( 'salary/{year?}/{month?}', 'Salary\SalaryController@import' )
         ->name( 'salary.import' )
         ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );
    Route::get( 'salary/{year?}/{month?}', 'Salary\SalaryController@index' )
         ->name( 'salary.index' )
         ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );

    Route::get( 'cars/{year?}/{month?}', 'CarController@index' )
         ->name( 'cars.index' )
         ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );
    Route::resource( 'users', 'UsersController' );
    Route::resource( 'cars', 'CarController' );
} );

Route::get( '/debug-sentry', function () {
    throw new Exception( 'debug Sentry error!' );
} );

Route::domain( 'work.diepxuan.com' )->group( function () {
    Route::get( '/', function () {
        return redirect()->route( 'tonghop' );
    } )->name( 'home' );

    Route::get( 'tonghop', 'Work\TonghopController@banhang' )->name( 'tonghop' );
    Route::post( 'tonghop', 'Work\TonghopController@banhang' )->name( 'tonghop' );

    Route::get( 'banhang/{from?}/{to?}', 'Work\BanhangController@index' )->name( 'banhang' );
    Route::resource( 'banhang', 'Work\BanhangController' );

    Route::get( 'muahang/{from?}/{to?}', 'Work\MuahangController@index' )->name( 'muahang' );
    Route::resource( 'muahang', 'Work\MuahangController' );
} );
