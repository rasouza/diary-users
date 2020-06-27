<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Provider\GenericProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
