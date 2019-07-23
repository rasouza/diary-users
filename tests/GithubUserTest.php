<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\User;
use App\GithubUser;

class GithubUserTest extends TestCase
{
    protected $socialite;
    protected function setUp(): void {
        $this->socialite = $this->createMock(Laravel\Socialite\Two\User::class);
        $this->socialite->method('getEmail')->willReturn('email');
        $this->socialite->name = 'name';
        $this->socialite->nickname = 'nickname';
        $this->socialite->email = 'email';
        $this->socialite->avatar = 'avatar';
    }
    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testFirstOrNewIsCalled()
    {
        $user = Mockery::mock('alias:App\User');
        $github = Mockery::mock('GithubUser');

        $github->shouldReceive('tokens->where->first');
        $github->shouldReceive('saveToken');

        $user->shouldReceive('firstOrNew')
            ->with($this->socialite)
            ->andReturn($github);

        GithubUser::auth($this->socialite);
        $this->expectNotToPerformAssertions();
    }
}
