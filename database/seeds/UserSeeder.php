<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create()->each(function ($user) {
            $user->tokens()->save(
                factory(App\Token::class)->make()
            );
        });

        factory(User::class, 1)->create()->each(function ($user) {
            $user->tokens()->saveMany([
                factory(App\Token::class)
                    ->states('github')
                    ->make(),
                factory(App\Token::class)
                    ->states('twitter')
                    ->make(),
            ]);
        });

        factory(User::class, 1)->create()->each(function ($user) {
            $user->tokens()->save(
                factory(App\Token::class)
                    ->states('twitter')
                    ->make()
            );
        });
    }
}
