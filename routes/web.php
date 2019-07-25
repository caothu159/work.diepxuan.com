<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Auth::routes( [
    'register' => false,
] );

Route::group( [
    'middleware' => [ 'auth', 'clearcache' ]
], function () {
    Route::get( '/', 'HomeController@index' )->name( 'home' );
    Route::get( 'home', 'HomeController@index' );

    Route::group( [ 'prefix' => 'salary' ], function () {
        Route::get( '{year?}/{month?}', 'SalaryController@index' )
             ->name( 'salary.index' )
             ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );
        Route::post( '{year?}/{month?}', 'SalaryController@import' )
             ->name( 'salary.import' )
             ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );
    } );

    Route::resource( 'users', 'UsersController' );
    Route::resource( 'cars', 'CarController' );
    Route::get( 'cars/{year?}/{month?}', 'CarController@index' )
         ->name( 'cars.index' )
         ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );
} );
