<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use \League\OAuth2\Client\Provider\GenericProvider;
use \League\OAuth2\Client\Provider\Github;
use App\Http\Controllers\HydraController;
use GuzzleHttp\Client;

class OAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('League\OAuth2\Client\Provider\Github', function () {
            return new Github([
                'clientId' => env('GITHUB_CLIENT_ID'),
                'clientSecret' => env('GITHUB_CLIENT_SECRET'),
                'redirectUri' => config('app.url') . '/oauth2/github/callback'
            ]);
        });

        $this->app->bind('League\OAuth2\Client\Provider\GenericProvider', function () {
            return new GenericProvider([
                'clientId'                => env('IDP_CLIENT_ID'),
                'clientSecret'            => env('IDP_CLIENT_SECRET'),
                'redirectUri'             => config('app.url') . '/oauth2/callback',
                'urlAuthorize'            => config('url.idp.external') . '/oauth2/auth',
                'urlAccessToken'          => config('url.idp.common') . '/oauth2/token',
                'urlResourceOwnerDetails' => config('url.idp.common') . '/userinfo'
            ]);
        });

        $this->app
            ->when(HydraController::class)
            ->needs(Client::class)
            ->give(function () {
                return new Client(['base_uri' => config('url.idp.admin') . '/oauth2/auth/']);
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
