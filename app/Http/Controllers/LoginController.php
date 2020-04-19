<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use Laravel\Lumen\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    private $client;
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://localhost:4445/oauth2/auth/']);
    }
    public function index(Request $request) {
        $content = '';
        $content .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';
        $content .= '<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">';
        $content .= '<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet" crossorigin="anonymous">';
        $content .= '<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>';
        $content .= '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>';
        $content .= '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>';
        $content .= '<a class="btn btn-social-icon btn-twitter" href="/accept-login/'.$request->input('login_challenge').'"><span class="fa fa-twitter"></span></a>';
        return $content;
    }

    public function acceptLogin(Request $request, $challenge) {
        $body = [
            'subject' => 'user1'
        ];
        $response = $this->client->request('PUT', "requests/login/accept?login_challenge={$challenge}", ['json' => $body]);
        $response = json_decode($response->getBody());
        return redirect($response->redirect_to);
    }

    public function showConsent(Request $request)
    {
        $challenge = $request->input('consent_challenge');
        $response = $this->client->request('GET', "requests/consent?consent_challenge={$challenge}");
        $content = '';
        $content .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';
        $content .= '<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">';
        $content .= '<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet" crossorigin="anonymous">';
        $content .= '<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>';
        $content .= '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>';
        $content .= '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>';
        $content .= '<a class="btn btn-social-icon btn-facebook" href="/accept-consent/'.$challenge.'"><span class="fa fa-facebook"></span></a>';
        return $content;
    }

    public function acceptConsent(Request $request, $challenge)
    {
        $body = [
            'grant_scope' => ['all'],
            // 'grant_access_token_audience' => ['test'],
            'remember' => false,
            'session' => [
                'access_token' => [
                    'user' => 'user2'
                ]
            ]
        ];
        $response = $this->client->request('PUT', "requests/consent/accept?consent_challenge={$challenge}", ['json' => $body]);
        $response = json_decode($response->getBody());
        return redirect($response->redirect_to);
    }
}
