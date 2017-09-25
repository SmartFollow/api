<?php

use App\Models\Users\Group;

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

$factory->define(App\Models\Users\User::class, function (Faker\Generator $faker) {
    static $password;

    $firstname = $faker->firstName;
    $lastname = $faker->lastName;
    $email = strtolower($firstname) . '.' . strtolower($lastname) . '@example.com';

    return [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
		'group_id' => Group::where('name', 'Students')->first()->id,
    ];
});
