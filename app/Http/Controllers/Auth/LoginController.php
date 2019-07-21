<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectGithub()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->stateless()->user();
        dd($user);
        // $user->token;
    }
}
