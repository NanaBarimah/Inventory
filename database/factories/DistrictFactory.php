<?php

use Faker\Generator as Faker;

$factory->define(App\District::class, function (Faker $faker) {
    $regions = App\Region::pluck('id')->toArray();
    return [
        'name' => $faker->city,
        'region_id' => $faker->randomElement($regions)
    ];
});
