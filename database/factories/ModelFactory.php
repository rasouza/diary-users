<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'nickname' => $faker->userName,
        'email' => $faker->email,
        'avatar' => $faker->imageUrl
    ];
});

$factory->define(App\Token::class, function(Faker\Generator $faker) {
    return [
        'provider' => 'github',
        'code' => $faker->md5
    ];
});

$factory->state(App\Token::class, 'github', function(Faker\Generator $faker) {
    return [
        'provider' => 'github',
        'code' => $faker->md5
    ];
});

$factory->state(App\Token::class, 'twitter', function(Faker\Generator $faker) {
    return [
        'provider' => 'twitter',
        'code' => $faker->md5
    ];
});


