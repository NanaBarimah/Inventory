<?php

use Faker\Generator as Faker;

$factory->define(App\Unit::class, function (Faker $faker) {
    $departments = App\Department::pluck('id')->toArray();
    $users = App\User::pluck('id')->toArray();

    return [
        'name' => $faker->country,
        'department_id' => $faker->randomElement($departments),
        //'user_id' => $faker->randomElement($users)
        'user_id' => $faker->randomElement($users)
    ];
});
