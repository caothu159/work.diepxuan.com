<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Auth::routes( [
    'register' => false,
] );

Route::domain( 'luong.diepxuan.com' )->group( function () {
    Route::get( '/', 'HomeController@index' )->name( 'home' );
    Route::get( 'home', 'HomeController@index' );

    Route::post( 'salary/{year?}/{month?}', 'Salary\SalaryController@import' )
         ->name( 'salary.import' )
         ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );
    Route::get( 'salary/{year?}/{month?}', 'Salary\SalaryController@index' )
         ->name( 'salary.index' )
         ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );

    Route::resource( 'users', 'UsersController' );
} );

Route::domain( 'work.diepxuan.com' )->group( function () {
    Route::get( '/', 'Work\BanhangController@index' );
    Route::get( 'banhang', 'Work\BanhangController@index' )->name( 'banhang' );
    Route::get( 'muahang', 'Work\MuahangController@index' )->name( 'muahang' );
} );
