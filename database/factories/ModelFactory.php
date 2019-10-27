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
        'name' => 'Admin',
        'username' => 'administrador',
        'email' => 'desarrollador@cdtec.cl',
        'password' => '12345678',
        'remember_token' => substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10),
        'api_token' => substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 50)
    ];
});

$factory->define(App\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => 'CDTEC'
    ];
});

$factory->define(App\Farm::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Campo de prueba'
    ];
});

DB::table('user_account')->insert(
    [
        'user_id' => User::select('id')->orderByRaw("RAND()")->first()->id,
        'account_id' => Account::select('id')->orderByRaw("RAND()")->first()->id,
    ]
);

