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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'reminder_credits' => mt_rand(0, 100)
    ];
});

$factory->define(App\Models\Contact::class, function (Faker\Generator $faker) {
    return [
        'user_id' => mt_rand(1, 100),
        'name' => $faker->name,
        'number' => str_random(10)
    ];
});

$factory->define(App\Models\User_reminder::class, function (Faker\Generator $faker) {
    return [
        'user_id' => mt_rand(1, 100),
        'send_datetime' => date('Y-m-d H:i:s'),
        'message' => $faker->text(100),
        'repeat_id' => mt_rand(1, 5),
        'recipient' => str_random(10)
    ];
});
