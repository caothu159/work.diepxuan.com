<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Auth::routes([
    'register' => false,
]);

Route::group(['middleware' => ['auth', 'clearcache']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('home', 'HomeController@index');
    Route::get('salary', 'SalaryController@index')->name('salary');
});

Route::group(['middleware' => ['admin', 'auth', 'clearcache']], function () {
    Route::get('/', 'Admin\\HomeController@index')->name('home');
    Route::get('home', 'Admin\\HomeController@index');
    Route::get('salary', 'Admin\\SalaryController@index')->name('salary');

    Route::get('salary/{year?}/{month?}/{type?}', 'Admin\\SalaryController@index')
        ->name('salary')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+', 'type' => '[a-z]+']);

    Route::get('employee/{year?}/{month?}', 'Admin\\ProductivityControllers@index')
        ->name('employee')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    Route::get('presence/{year?}/{month?}', 'Admin\\ProductivityControllers@index')
        ->name('presence')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    Route::get('division/{year?}/{month?}', 'Admin\\ProductivityControllers@index')
        ->name('division')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    Route::get('productivity/{year?}/{month?}', 'Admin\\ProductivityControllers@index')
        ->name('productivity')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('productivity/{year?}/{month?}', 'Admin\\ProductivityControllers@index')
        ->name('productivity')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
});
