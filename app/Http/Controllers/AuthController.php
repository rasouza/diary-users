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

        Cookie::queue('login', $accessToken->getToken(), 60*24*30); // 30 days

        dd($accessToken, $this->provider->getResourceOwner($accessToken)->toArray());
        // return redirect()->away(env('FRONTEND_URL'));
    }
}
