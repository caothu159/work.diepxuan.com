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
    Route::get( 'salary', 'SalaryController@index' )->name( 'salary' );

    Route::get( 'salary/{year?}/{month?}', 'SalaryController@index' )
         ->name( 'salary' )
         ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );

    Route::group( [
        'middleware' => [ 'admin' ],
    ], function () {
        Route::post( 'salary/{year?}/{month?}', 'SalaryController@import' )
             ->name( 'salary' )
             ->where( [ 'year' => '[0-9]+', 'month' => '[0-9]+' ] );
    } );
} );
