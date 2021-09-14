<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Blade custom directives for isAdmin

        Blade::directive('isAdmin', function () {
            return "<?php if(Auth::user() && Auth::user()->isAdmin()): ?>";
        });

        Blade::directive('endisAdmin', function () {
            return "<?php endif; ?>";
        });
    }
}
