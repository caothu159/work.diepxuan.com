<?php
/**
 * Copyright © DiepXuan, Ltd. All rights reserved.
 */

use App\Http\Controllers\Salary\SalaryController;
use App\Http\Controllers\SalaryUserController;
use App\Http\Controllers\Work\BanhangController;
use App\Http\Controllers\Work\MuahangController;
use App\Http\Controllers\Work\TonghopController;
use App\Http\Middleware\ClearCache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false,
]);

Route::domain('luong.diepxuan.com')->group(function () {
    Route::middleware([ClearCache::class])->group(function () {
        Route::get('/{time?}/{name?}', [SalaryController::class, 'index'])
            ->name('luong.home')
            ->where([
                'time' => '[0-9]+\-[0-9]+',
                'name' => '[a-zA-Z]+\-?[a-zA-Z]*',
            ]);
        Route::get('/home', [SalaryController::class, 'index']);
        Route::resource('salary', SalaryController::class);
        Route::resource('salaryuser', SalaryUserController::class);

        Route::resource('users', 'UsersController');
    });
});

Route::get('/debug-sentry', function () {
    throw new Exception('debug Sentry error!');
});

Route::domain('work.diepxuan.com')->group(function () {
    Route::middleware([ClearCache::class])->group(function () {
        Route::get('/', function () {
            return redirect()->route('tonghop');
        })->name('work.home');

        Route::get('tonghop/{from?}/{to?}', [TonghopController::class, 'index'])->name('tonghop');
        Route::resource('tonghop', TonghopController::class);

        Route::get('banhang/{from?}/{to?}', [BanhangController::class, 'index'])->name('banhang');
        Route::resource('banhang', BanhangController::class);

        Route::get('muahang/{from?}/{to?}', [MuahangController::class, 'index'])->name('muahang');
        Route::resource('muahang', MuahangController::class);
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
