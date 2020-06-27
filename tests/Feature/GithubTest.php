<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Mockery;

use League\OAuth2\Client\Provider\Github;
use App\User;


class GithubTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGithubAuthRedirect()
    {
        $this->mock(Github::class, function ($mock) {
            $mock->shouldReceive('getAuthorizationUrl')
                ->once()
                ->andReturn('http://diary-users');
        });

        $response = $this->get('/oauth2/github/auth');
        $response->assertRedirect('http://diary-users');
    }

    public function testGetUserInfo()
    {
        $accessToken = Mockery::mock('League\OAuth2\Client\Token\AccessToken');
        $accessToken->shouldReceive('getToken')->andReturn('e09b20a1f330cb12ce098405e563f49ce0edca54');
        $resourceOwner = [
            'name' => 'Dummy User',
            'login' => 'dummy123',
            'email' => 'dummy@email.com',
            'avatar_url' => 'http://dummy.com/image.png',
        ];
        $challenge = 'my_hash_challenge';

        $this->mock(Github::class, function ($mock) use ($resourceOwner, $accessToken) {
            $mock->shouldReceive([
                'getAccessToken' => $accessToken,
                'getResourceOwner->toArray' => $resourceOwner,
            ]);
        });

        $this->mock(User::class, function ($mock) {
            $mock->shouldReceive('firstOrNew');
        });


        $response = $this->get("/oauth2/github/callback?state={$challenge}");

        $response->assertRedirect("/accept-login/dummy123?login_challenge=my_hash_challenge&avatar=http://dummy.com/image.png&name=Dummy User");
        $this->assertDatabaseHas('users', ['email' => 'dummy@email.com']);
    }
}
