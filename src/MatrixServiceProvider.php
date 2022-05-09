<?php

namespace AksService\Matrix;

use Illuminate\Support\ServiceProvider;

class MatrixServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'matrix');
    }

    public function boot()
    {
        /*
         * prepare publishing the config file for
         * `php artisan vendor:publish --provider="AksService\Matrix\MatrixServiceProvider" --tag="config"`
         */
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('matrix.php'),
            ], 'config');
        }
    }
}
