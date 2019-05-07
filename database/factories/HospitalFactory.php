<?php

use Faker\Generator as Faker;

$factory->define(App\Hospital::class, function (Faker $faker) {
    $districts = App\District::pluck('id')->toArray();
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'contact_number' => $faker->phoneNumber,
        'district_id' => $faker->randomElement($districts)
    ];
});
