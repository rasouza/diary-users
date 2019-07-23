<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Services\GithubLogin;
use App\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @expectedException MongoDB\Driver\Exception\BulkWriteException
     */
    public function testDuplicatedUserNotAllowed()
    {
        $user = factory(App\User::class, 2)->create([
            'email' => 'test@example.com'
        ]);

        // $this->seeInDatabase('users', ['email' => $user->email]);
        // $this->seeInDatabase('users', ['email' => $user->email]);
    }

    public function testNewUser() {
        $socialite = $this->createMock(Laravel\Socialite\Two\User::class);
        $socialite->method('getEmail')->willReturn('email');
        $socialite->name = 'name';
        $socialite->nickname = 'nickname';
        $socialite->email = 'email';
        $socialite->avatar = 'avatar';

        $user = User::firstOrNew($socialite);
        $this->assertEquals($user->email, 'email');
        $this->assertInstanceOf(User::class, $user);
    }
    public function testExisingUser()
    {
        $socialite = $this->createMock(Laravel\Socialite\Two\User::class);
        $socialite->method('getEmail')->willReturn('test@example.com');
        factory(App\User::class)->create([
            'email' => 'test@example.com'
        ]);

        $user = User::firstOrNew($socialite);

        $this->assertEquals($user->email, 'test@example.com');
    }
}
