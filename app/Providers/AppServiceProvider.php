<?php

namespace App\Providers;

use App\Services\WindowsCompatibleFilesystem;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('files', function () {
            return new WindowsCompatibleFilesystem;
        });
        $this->app->alias('files', Filesystem::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
