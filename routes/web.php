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

    /** Salary */
    Route::get('salary/{year?}/{month?}/{type?}', 'Admin\\SalaryController@index')
        ->name('salary')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+', 'type' => '[a-z]+']);

    /** Employee */
    Route::get('employee/{year?}/{month?}', 'Admin\\EmployeeController@index')
        ->name('employee')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('employee/{year?}/{month?}', 'Admin\\EmployeeController@index')
        ->name('employee')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /** Presence */
    Route::get('presence/{year?}/{month?}', 'Admin\\PresenceController@index')
        ->name('presence')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('presence/{year?}/{month?}', 'Admin\\PresenceController@index')
        ->name('presence')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /** Division */
    Route::get('division/{year?}/{month?}', 'Admin\\ProductivityController@index')
        ->name('division')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /** Productivity */
    Route::get('productivity/{year?}/{month?}', 'Admin\\ProductivityController@index')
        ->name('productivity')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('productivity/{year?}/{month?}', 'Admin\\ProductivityController@index')
        ->name('productivity')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
});
