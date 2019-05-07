<?php

use Faker\Generator as Faker;

$factory->define(App\Equipment_request::class, function (Faker $faker) {
    $requests_id = App\Requests::pluck('id')->toArray();
    $equipment_code = App\Equipment::pluck('code')->toArray();
    //$equipment_code = array_rand($equipment_code, 2);
    
    //$hospital_id = App\Hospital::pluck('id')->toArray();

    return [
        'requests_id' => $faker->randomElement($requests_id),
        'equipment_code' => $faker->randomElement($equipment_code)
    ];
});
