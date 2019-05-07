<?php

use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    $hospitals = App\Hospital::pluck('id')->toArray();
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'username' => $faker->unique()->userName,
        'phone_number' => $faker->phoneNumber,
        'role' => 'Admin',
        'password' => bcrypt('Password'),
        'remember_token' => str_random(10),
        'id' => md5($faker->userName.microtime()),
        'hospital_id' => $faker->randomElement($hospitals)
    ];
});
