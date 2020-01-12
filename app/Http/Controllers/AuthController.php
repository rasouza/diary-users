<?php

namespace App\Http\Controllers;

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
            'clientId'                => 'diary-users',    // The client ID assigned to you by the provider
            'clientSecret'            => 'ZXhhbXBsZS1hcHAtc2VjcmV0',   // The client password assigned to you by the provider
            'redirectUri'             => 'http://localhost:8000/oauth/google/callback',
            'urlAuthorize'            => 'http://localhost:5556/dex/auth?scope=openid',
            'urlAccessToken'          => 'http://localhost:5556/dex/token',
            'urlResourceOwnerDetails' => 'http://localhost:5556/dex/userinfo'
        ]);
    }

    public function login()
    {
        echo $this->provider->getAuthorizationUrl();
    }

    public function callback()
    {
        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.
        echo 'Access Token: ' . $accessToken->getToken() . "<br>";
        echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
        echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
        echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

        // Using the access token, we may look up details about the
        // resource owner.
        $resourceOwner = $this->provider->getResourceOwner($accessToken);

        var_export($resourceOwner->toArray());
        $request = $this->provider->getAuthenticatedRequest(
            'GET',
            'http://localhost:5556/dex/userinfo',
            $accessToken
        );
        dd($request);
    }
}
