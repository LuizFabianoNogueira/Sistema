<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [__DIR__.'/Filters' => base_path('app/http/Filters')],
            'filters'
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
