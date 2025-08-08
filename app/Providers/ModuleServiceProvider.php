<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $modulesPath = base_path('app/Modules');
        //Load Modules
        foreach (scandir($modulesPath) as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }
            $routePath = $modulesPath . '/' . $module . '/Routes';
            $viewPath = $modulesPath . '/' . $module . '/Views';
            $migrationPath = $modulesPath . '/' . $module . '/Database/Migrations';

            if (is_dir($routePath)) {
                Route::middleware('web')
                        ->group($routePath.'/web.php');
            }

            if (is_dir($viewPath)) {
                $this->loadViewsFrom($viewPath, strtolower($module) );
            }

            if (is_dir($migrationPath)) {                
                $this->loadMigrationsFrom($migrationPath);
            }
        }
    }
}
