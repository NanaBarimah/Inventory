<?php

use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    //$users = App\User::pluck('id')->toArray();
    $hospitals = App\Hospital::pluck('id')->toArray();

    return [
        'name' => $faker->streetName,
        'hospital_id' => $faker->randomElement($hospitals),
        //'user_id' => $faker->randomElement($users)
        'user_id' => factory(App\User::class)->create([
            'firstname' => $faker->firstName,
            'lastname' => $faker->lastName,
            'username' => $faker->unique()->userName,
            'phone_number' => $faker->phoneNumber,
            'role' => 'Department Head',
            'password' => bcrypt('123456'),
            'is_unit_head' => 1,
            'remember_token' => str_random(10),
            'id' => md5($faker->userName.microtime()),
            'hospital_id' => $faker->randomElement($hospitals)
        ])
    ];
});
