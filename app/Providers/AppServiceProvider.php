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
        $this->app->bind('League\OAuth2\Client\Provider\Github', function () {
            return new Github([
                'clientId' => env('GITHUB_CLIENT_ID'),
                'clientSecret' => env('GITHUB_CLIENT_SECRET'),
                'redirectUri' => env('APP_URL') . '/oauth2/github/callback'
            ]);
        });

        $this->app->bind('League\OAuth2\Client\Provider\GenericProvider', function () {
            return new GenericProvider([
                'clientId'                => env('IDP_CLIENT_ID'),
                'clientSecret'            => env('IDP_CLIENT_SECRET'),
                'redirectUri'             => env('APP_URL') . '/oauth2/callback',
                'urlAuthorize'            => env('IDP_EXTERNAL_URL') . '/oauth2/auth',
                'urlAccessToken'          => env('IDP_URL') . '/oauth2/token',
                'urlResourceOwnerDetails' => env('IDP_URL') . '/userinfo'
            ]);
        });
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
