<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Github;
use App\User;

class GithubController extends Controller
{
    private $provider;

    public function __construct(Github $github) {
        $this->provider = $github;
    }

    public function auth(Request $request)
    {
        $challenge = $request->input('login_challenge');
        return redirect($this->provider->getAuthorizationUrl(['state' => $challenge]));
    }

    public function callback(Request $request)
    {
        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $request->input('code')
        ]);
        $resourceOwner = $this->provider->getResourceOwner($accessToken)->toArray();

        $user = User::firstOrNew([ 'email' => $resourceOwner['email'] ]);
        $user->fill([
            'name' => $resourceOwner['name'],
            'username' => $resourceOwner['login'],
            'avatar' => $resourceOwner['avatar_url'],
            'github_token' => $accessToken->getToken()
        ]);
        $user->save();

        $challenge = $request->input('state');
        dump($accessToken, $resourceOwner, $user);
        return redirect("/accept-login/{$user->username}?login_challenge={$challenge}");
    }
}
