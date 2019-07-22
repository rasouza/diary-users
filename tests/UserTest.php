<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Services\GithubLogin;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserIsInDatabase()
    {
        $user = factory(App\User::class)->create([
            'email' => 'test@example.com'
        ]);



        $this->seeInDatabase('users', ['email' => $user->email]);
    }
    public function testUserIsNotInDatabase()
    {
        $user = factory(App\User::class)->make();

        $this->missingFromDatabase('users', ['email' => 'test@example.com']);
    }
}
