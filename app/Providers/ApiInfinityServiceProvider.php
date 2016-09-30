<?php

namespace App\Providers;

use App\http\InfinityServices;
use Illuminate\Support\ServiceProvider;

class ApiInfinityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('InfinityServices', function(){
            return new App\http\InfinityServices();
        });
    }
}
