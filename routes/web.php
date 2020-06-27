<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth', 'AuthController@auth');
Route::get('/oauth2/callback', 'AuthController@callback');
Route::get('/oauth2/github/auth', 'GithubController@auth');
Route::get('/oauth2/github/callback', 'GithubController@callback');

// HYDRA endpoints
Route::get('/consent', 'HydraController@showConsent');
Route::get('/accept-login/{user}', 'HydraController@acceptLogin');
Route::get('/accept-consent', 'HydraController@acceptConsent');
Route::get('/token-info', 'HydraController@acceptConsent');
