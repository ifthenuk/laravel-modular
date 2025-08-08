<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tambah support untuk migration di Modules
        $modulePath = base_path('Modules');
        if (File::isDirectory($modulePath)) {
            $modules = File::directories($modulePath);
            foreach ($modules as $module) {
                $migrationPath = $module . '/Database/Migrations';
                if (File::isDirectory($migrationPath)) {
                    $this->loadMigrationsFrom($migrationPath);
                }
            }
        }
    }
}
