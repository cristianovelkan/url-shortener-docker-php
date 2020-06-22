<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define('App\User', function ($faker) {
    return [
        'id' => \Illuminate\Support\Str::slug($faker->name),
    ];
});

/**
 * Factory definition for model App\Task.
 */

$factory->define(App\Url::class, function ($faker) {

    $user = factory('App\User')->create();
    $url = $faker->url;

    return [
        'id' => App\Url::count()+1,
        'user_id' => $user['id'],
        'url' => $url,
        'short_url' => (new \App\Http\Controllers\UrlsController)->randomUrl(),
        'hits' => 0
    ];
});



