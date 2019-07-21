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
        'avatar' => $faker->imageUrl,
        'tokens' => [
            'github' => $faker->md5
        ]
    ];
});

$factory->state(App\User::class, 'connected', function(Faker\Generator $faker) {
    return [
        'tokens' => [
            'github' => $faker->md5,
            'twitter' => $faker->md5
        ]
    ];
});

$factory->state(App\User::class, 'twitter', function(Faker\Generator $faker) {
    return [
        'tokens' => [
            'twitter' => $faker->md5
        ]
    ];
});
