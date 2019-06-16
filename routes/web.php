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
    Route::get('salary/{year?}/{month?}', 'SalaryController@index')
        ->name('admin.salary')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
    Route::post('salary/{year?}/{month?}', 'SalaryController@import')
        ->name('admin.salary')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /* Employee */
    Route::post('employee/{year?}/{month?}', 'EmployeeController@import')
        ->name('admin.employee')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /* Presence */
    Route::post('presence/{year?}/{month?}', 'PresenceController@import')
        ->name('admin.presence')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /* Division */
    Route::post('division/{year?}/{month?}', 'DivisionController@import')
        ->name('admin.division')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);

    /* Productivity */
    Route::post('productivity/{year?}/{month?}', 'ProductivityController@import')
        ->name('admin.productivity')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
});
