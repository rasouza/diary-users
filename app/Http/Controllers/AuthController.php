<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use \League\OAuth2\Client\Provider\GenericProvider;

class AuthController extends Controller
{
    private $provider;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GenericProvider $provider)
    {
        $this->provider = $provider;
    }

    public function auth()
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

        return response()->withCookie('meu_token', $accessToken)->json(['jwt' => $accessToken->id_token]);
    }
}
