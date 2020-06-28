<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HydraController extends Controller
{
    private $client;
    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('IDP_ADMIN_URL') . '/oauth2/auth/']);
    }

    public function acceptLogin(Request $request, $user)
    {
        $body = [
            'subject' => $user,
            'context' => $request->only(['name', 'avatar'])
        ];
        $challenge = $request->input('login_challenge');
        $url = "requests/login/accept?login_challenge={$challenge}";

        $response = $this->client->request('PUT', $url, ['json' => $body]);
        $response = json_decode($response->getBody());
        return redirect($response->redirect_to);
    }

    public function showConsent(Request $request)
    {
        $challenge = $request->input('consent_challenge');
        $url = "requests/consent?consent_challenge={$challenge}";

        $response = $this->client->get($url);
        $response = json_decode($response->getBody());
        extract(get_object_vars($response->context));

        return redirect("/accept-consent?consent_challenge={$challenge}&name={$name}&avatar={$avatar}");
    }

    public function acceptConsent(Request $request)
    {
        $challenge = $request->input('consent_challenge');
        $body = [
            'grant_scope' => ['openid'],
            'remember' => false,
            'session' => [
                'id_token' => $request->only(['name', 'avatar'])
            ]
        ];

        $url = "requests/consent/accept?consent_challenge={$challenge}";
        $response = $this->client->request('PUT', $url, ['json' => $body]);
        $response = json_decode($response->getBody());
        return redirect($response->redirect_to);
    }
}
