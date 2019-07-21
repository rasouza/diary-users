<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gentux\Healthz\Healthz;
use Gentux\Healthz\Checks\General\EnvHealthCheck;
use Gentux\Healthz\Checks\Laravel\DatabaseHealthCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Healthz::class, function() {
            $env = new EnvHealthCheck();
            $db = new DatabaseHealthCheck();
            return new Healthz([$env, $db]);
        });
    }
}
