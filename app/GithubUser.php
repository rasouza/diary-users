<?php

namespace App;

class GithubUser extends User
{
    protected $collection = 'users';

    public static function auth($socialiteUser) {
        $token = $socialiteUser->token;
        $user = self::firstOrNew($socialiteUser);
        $user->saveToken($token);

        return $user;
    }

    protected function saveToken($token) {
        $github = $this->tokens()
            ->where('provider','github')
            ->first();

        $github = $github ?? new Token([
            'provider' => 'github',
            'code' => $token
        ]);

        $this->tokens()->save($github);
    }
}
