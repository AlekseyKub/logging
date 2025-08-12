<?php

namespace AlekseyKub\Logging\Providers;

use Illuminate\Support\ServiceProvider;
use AlekseyKub\Logging\Console\Commands\CopyConfigCommand;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CopyConfigCommand::class
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Log::info('Migrations path: ' . realpath(__DIR__ . '/../database/migrations'));
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
    }
}