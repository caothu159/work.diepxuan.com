<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Auth::routes([
    'register' => false,
]);

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
Route::get('home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => ['admin']], function () {
    Route::get('admin', 'HomeController@admin');
});
