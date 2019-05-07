<?php

use Faker\Generator as Faker;

$factory->define(App\Admin::class, function (Faker $faker) {
    $regions = App\Region::pluck('id')->toArray();

    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'username' => $faker->unique()->userName,
        'phone_number' => $faker->phoneNumber,
        'role' => 'Biomedical Engineer',
        'password' => bcrypt('123456'), 
        'remember_token' => str_random(10),
        'id' => md5($faker->userName.microtime()),
        'region_id' => $faker->randomElement($regions)
    ];
});
