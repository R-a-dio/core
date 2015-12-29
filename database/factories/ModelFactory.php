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
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'dj_id' => null,
    ];
});

$factory->define(App\DJ::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'visible' => true,
    ];
});

$factory->define(App\Song::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->text,
        'artist' => $faker->name,
        'album' => $faker->text,
        'tags' => $faker->words(10, true),
        'usable' => $faker->boolean(),
        'hash' => sha1(random_bytes(24)),
        'path' => $faker->randomElement(['test.mp3', 'test.ogg', 'test.flac']),
    ];
});

$factory->defineAs(App\Song::class, 'ogg', function () use ($factory) {
    $song = $factory->raw(App\Song::class);

    return array_merge($song, ['path' => 'test.ogg']);
});

$factory->defineAs(App\Song::class, 'mp3', function () use ($factory) {
    $song = $factory->raw(App\Song::class);

    return array_merge($song, ['path' => 'test.mp3']);
});

$factory->defineAs(App\Song::class, 'flac', function () use ($factory) {
    $song = $factory->raw(App\Song::class);

    return array_merge($song, ['path' => 'test.flac']);
});
