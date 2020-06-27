<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    private $provider;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => env('IDP_CLIENT_ID'),    // The client ID assigned to you by the provider
            'clientSecret'            => env('IDP_CLIENT_SECRET'),   // The client password assigned to you by the provider
            'redirectUri'             => env('APP_URL') . '/oauth2/callback',
            'urlAuthorize'            => env('IDP_EXTERNAL_URL') . '/oauth2/auth',
            'urlAccessToken'          => env('IDP_URL') . '/oauth2/token',
            'urlResourceOwnerDetails' => env('IDP_URL') . '/userinfo'
        ]);
    }

    public function auth(Request $request)
    {
        return redirect($this->provider->getAuthorizationUrl());
    }

    public function callback(Request $request)
    {
        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $request->input('code')
        ]);

        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.
        echo 'Access Token: ' . $accessToken->getToken() . "<br>";
        echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
        echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
        echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

        // Using the access token, we may look up details about the
        // resource owner.
        $resourceOwner = $this->provider->getResourceOwner($accessToken)->toArray();

        // dd($accessToken, $resourceOwner);
        return response()->withCookie('meu_token', $accessToken)->json(['jwt' => $accessToken->id_token])
    }
}
