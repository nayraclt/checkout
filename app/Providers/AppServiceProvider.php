<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\ProductIntegrationServiceInterface',
            'App\Services\ProductIntegrationService'
        );

        $this->app->bind(
            'App\Services\ProductServiceInterface',
            'App\Services\ProductService'
        );

        $this->app->register(\Raiadrogasil\Common\ServiceProvider::class);
        $this->app->register(\Raiadrogasil\Configuration\ServiceProvider::class);
        $this->app->register(\Raiadrogasil\Connect\ServiceProvider::class);
        $this->app->register(\Raiadrogasil\Token\ServiceProvider::class);

        if ($this->app->environment(['local'])) {
            $this->app->register(\Raiadrogasil\Test\ServiceProvider::class);
        }
    }
}
