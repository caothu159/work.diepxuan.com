<?php

namespace App\Modules;

use File;

class ModuleServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {

        // Khai báo commands
        $this->commands([
        // namespace của commands đặt tại đây
        // '\modules\Demo\src\Http\Commands\DemoCommand'
        ]);
    }

    public function boot()
    {
        $modules = array_map('basename', File::directories(__DIR__));

        foreach ($modules as $module) {
            $this->registerModule($module);
        }
    }

    // Khai báo đăng ký cho từng modules
    private function registerModule($moduleName)
    {
        $modulePath = __DIR__ . DIRECTORY_SEPARATOR . "$moduleName" . DIRECTORY_SEPARATOR;

        // Khai báo route
        if (File::exists($modulePath . "routes.php")) {
            $this->loadRoutesFrom($modulePath . "routes.php");
        }

        // Khai báo views
        // Gọi view thì ta sử dụng: view('Demo::index'), @extends('Demo::index'), @include('Demo::index')
        if (File::exists($modulePath . "Views")) {
            $this->loadViewsFrom($modulePath . "Views", $moduleName);
        }
    }
}
