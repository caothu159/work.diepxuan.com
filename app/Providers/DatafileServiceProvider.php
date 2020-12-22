<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DatafileServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [];

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        // \App\Services\DatafileServiceInterface::class => \App\Services\DatafileService::class
        \App\Services\SalaryServiceInterface::class => \App\Services\SalaryService::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(
        //     \App\Services\DatafileServiceInterface::class,
        //     \App\Services\DatafileService::class
        // );
        // $this->app->singleton(
        //     \App\Services\SalaryServiceInterface::class,
        //     \App\Services\SalaryService::class
        // );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            // \App\Services\DatafileServiceInterface::class,
            \App\Services\SalaryServiceInterface::class,
        ];
    }
}
