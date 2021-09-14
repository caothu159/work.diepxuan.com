<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Api\Controllers\DmvtController;
use App\Modules\Api\Controllers\CtubanhangController;
use App\Modules\Api\Controllers\CtubanhangvtController;
use App\Modules\Api\Controllers\WorkController;
use App\Http\Middleware\ClearCache;
use App\Modules\Api\Controllers\AuthController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Admin;

Route::domain("work.diepxuan.com")->group(function () {

    Route::middleware([
        'api',
        Admin::class,
        Authenticate::class,
        'auth:sanctum'
    ])->group(function () {

        Route::group([
            'module' => 'Api',
            'prefix'=>'api/v1',
            // 'namespace' => 'App\Modules\Api\Controllers'
        ], function () {
            Route::resource("dmvt", DmvtController::class);
            Route::resource("hdbh", CtubanhangController::class);
            Route::resource("hdbhvt", CtubanhangvtController::class);
        });
    });

    Route::middleware([
        'web',
        ClearCache::class,
        Authenticate::class,
        Admin::class,
    ])->group(function () {
        Route::get('/token', [AuthController::class, 'token']);
    });


    Route::middleware([
        'web',
        ClearCache::class,
    ])->group(function () {
        Route::get("/home", [WorkController::class, "index"])->name("home");
        Route::get("/{any}", [WorkController::class, "index"])->where("any", ".*");
    });
});
