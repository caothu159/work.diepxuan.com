<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
        try {
            $this->{'register' . ucfirst( $this->app->environment() )}();
        } catch ( \Exception $e ) {
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    private function registerLocal() {
        $this->app->register( \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class );
    }
}
