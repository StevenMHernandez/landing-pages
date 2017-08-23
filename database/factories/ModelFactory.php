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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Subscriber::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
    ];
});

$factory->define(App\Models\LandingPage::class, function (Faker\Generator $faker) {
    return [
        'subdomain' => $faker->name,
    ];
});

$factory->define(App\Models\EmailContent::class, function (Faker\Generator $faker) {
    return [];
});

$factory->define(App\Models\Feature::class, function (Faker\Generator $faker) {
    return [
        'icon' => 'fa-question_circle',
        'header' => $faker->sentence(3),
        'body' => $faker->sentence(12),
    ];
});

$factory->define(App\Models\SocialLink::class, function (Faker\Generator $faker) {
    return [
        'icon' => 'icon-twitter',
        'url' => $faker->url,
    ];
});
