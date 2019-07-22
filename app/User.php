<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Moloquent;
use DB;

class User extends Moloquent implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'nickname', 'avatar'
    ];

    public static function firstOrNew($socialiteUser) {
        $user = self::where('email', $socialiteUser->getEmail())->first();
        if ($user)
            return $user;

        $userData = collect($socialiteUser)->only(['name', 'nickname', 'avatar', 'email']);

        return self::create($userData->toArray());
    }

    public function tokens() {
        return $this->embedsMany(Token::class);
    }
}
