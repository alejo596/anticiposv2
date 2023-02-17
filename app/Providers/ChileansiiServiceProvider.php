<?php

namespace Twgroupcl\Chileansii;

use Illuminate\Support\ServiceProvider;

class ChileansiiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'chileansii');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'chileansii');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('chileansii.php'),
            ], 'config');

            // Publish migrations and seeds
            $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');
            $this->publishes([__DIR__.'/database/seeds' => database_path('seeds')], 'seeds');

            // 
            $this->publishes([__DIR__.'/models' => app_path('Models')], 'models');

            // Registering package commands.
            // $this->commands([]);
        }

        
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'chileansii');

        // Register the main class to use with the facade
        $this->app->singleton('chileansii', function () {
            return new Chileansii;
        });
    }
}