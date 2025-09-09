<?php

namespace Severnaya\Logging;

use Illuminate\Support\ServiceProvider;
use Severnaya\Logging\Observers\ModelObserver;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");

        $this->publishes([
            __DIR__ . '/../config/logging_models.php' => config_path('logging_models.php'),
        ], 'config');

        $models = config('logging_models.models', []);
        foreach ($models as $model) {
            $model::observe(ModelObserver::class);
        }
    }
}
