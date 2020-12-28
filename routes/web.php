<?php

use App\Http\Controllers\Salary\TestController;
use App\Http\Controllers\SalaryUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ClearCache;

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
        Route::get('/{time?}/{name?}', [TestController::class, 'index'])
            ->name('luong.home')
            ->where([
                'time' => '[0-9]+\-[0-9]+',
                'name' => '[a-zA-Z]+\-?[a-zA-Z]*',
            ]);
        Route::get('/home', [TestController::class, 'index']);
        Route::resource('salary', TestController::class);
        Route::resource('salaryuser', SalaryUserController::class);

        Route::resource('users', 'UsersController');
    });
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
