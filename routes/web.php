<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

Route::get('/', 'HomeController@index')->name('home');

Auth::routes([
    // 'register' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');
