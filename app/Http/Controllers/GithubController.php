<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Github;
use App\User;

class GithubController extends Controller
{
    private $provider;

    private function persist($userInfo)
    {
        $user = User::firstOrNew([ 'email' => $userInfo['email'] ]);
        $user->fill($userInfo);
        $user->save();

        return $user;
    }

    private function getUserInfo($code)
    {
        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $code
        ]);
        $resourceOwner = $this->provider->getResourceOwner($accessToken)->toArray();

        return [
            'email' => $resourceOwner['email'],
            'name' => $resourceOwner['name'],
            'username' => $resourceOwner['login'],
            'avatar' => $resourceOwner['avatar_url'],
            'github_token' => $accessToken->getToken()
        ];
    }

    public function __construct(Github $github)
    {
        $this->provider = $github;
    }

    public function auth(Request $request)
    {
        $challenge = $request->input('login_challenge');
        return redirect($this->provider->getAuthorizationUrl(['state' => $challenge]));
    }

    public function callback(Request $request)
    {
        $userInfo = $this->getUserInfo($request->input('code'));
        $user = $this->persist($userInfo);

        $challenge = $request->input('state');
        return redirect("/accept-login/{$user->username}?login_challenge={$challenge}&avatar={$user->avatar}&name={$user->name}");
    }
}
