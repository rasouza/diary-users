<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use \League\OAuth2\Client\Provider\GenericProvider;
use Illuminate\Support\Facades\Cookie;

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

        $idToken = $accessToken->getValues()['id_token'];

        return redirect()->away(config('url.frontend') . "/auth/callback#{$idToken}");
    }
}
