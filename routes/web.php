<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/auth', 'AuthController@auth');
$router->get('/oauth2/callback', 'AuthController@callback');
$router->get('/oauth2/github/auth', 'GithubController@auth');
$router->get('/oauth2/github/callback', 'GithubController@callback');

// HYDRA endpoints
$router->get('/consent', 'LoginController@showConsent');
$router->get('/accept-login/{user}', 'LoginController@acceptLogin');
$router->get('/accept-consent', 'LoginController@acceptConsent');
$router->get('/token-info', 'LoginController@acceptConsent');

$router->get('/headers', function () {
    dd(app('request')->header());
});

$router->get('/env', function () {
    dd($_ENV);
});
