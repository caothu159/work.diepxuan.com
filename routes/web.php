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

Route::group([
    'prefix'     => 'admin',
    'namespace'  => 'Admin',
    'middleware' => ['admin', 'auth', 'clearcache'],
], function () {
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::get('home', 'HomeController@index');
    Route::get('salary', 'SalaryController@index')->name('admin.salary');

    /* Salary */
    Route::get('salary/{year?}/{month?}/{type?}', 'SalaryController@index')
        ->name('admin.salary')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+', 'type' => '[a-z]+']);

    /* Employee */
    Route::get('employee/{year?}/{month?}', 'EmployeeController@index')
        ->name('admin.employee')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('employee/{year?}/{month?}', 'EmployeeController@store')
        ->name('admin.employee')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /* Presence */
    Route::get('presence/{year?}/{month?}', 'PresenceController@index')
        ->name('admin.presence')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('presence/{year?}/{month?}', 'PresenceController@store')
        ->name('admin.presence')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /* Division */
    Route::get('division/{year?}/{month?}', 'DivisionController@index')
        ->name('admin.division')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('division/{year?}/{month?}', 'DivisionController@store')
        ->name('admin.division')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /* Productivity */
    Route::get('productivity/{year?}/{month?}', 'ProductivityController@index')
        ->name('admin.productivity')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('productivity/{year?}/{month?}', 'ProductivityController@store')
        ->name('admin.productivity')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
});
