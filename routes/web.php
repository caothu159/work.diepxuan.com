<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Auth::routes([
    'register' => false,
]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('home', 'HomeController@index');
    Route::get('salary', 'SalaryController@index')->name('salary');
});

Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/', 'Admin\\HomeController@index')->name('home');
    Route::get('home', 'Admin\\HomeController@index');
    Route::get('salary', 'Admin\\SalaryController@index')->name('salary');

    Route::get('salary/{year?}/{month?}', 'Admin\\SalaryController@show')
        ->name('salary')
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+']);
});
