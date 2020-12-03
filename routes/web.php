<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Auth::routes([
    'register' => false,
]);

Route::domain('luong.diepxuan.com')->group(function () {
    Route::get('/', 'Salary\TestController@index')->name('home');
    Route::get('home', 'Salary\TestController@index');
    Route::resource('salary', 'Salary\TestController');

    Route::resource('users', 'UsersController');
});

Route::get('/debug-sentry', function () {
    throw new Exception('debug Sentry error!');
});

Route::domain('work.diepxuan.com')->group(function () {
    Route::get('/', function () {
        return redirect()->route('tonghop');
    })->name('home');

    Route::get('tonghop/{from?}/{to?}', 'Work\TonghopController@index')->name('tonghop');
    Route::resource('tonghop', 'Work\TonghopController');

    Route::get('banhang/{from?}/{to?}', 'Work\BanhangController@index')->name('banhang');
    Route::resource('banhang', 'Work\BanhangController');

    Route::get('muahang/{from?}/{to?}', 'Work\MuahangController@index')->name('muahang');
    Route::resource('muahang', 'Work\MuahangController');
});
