<?php

use Faker\Generator as Faker;

$factory->define(App\Service_Vendor::class, function (Faker $faker) {
    $hospitals = App\Hospital::pluck('id')->toArray();
    return [
        'name' => 'None',
        'contact_number'=> 'No contact',
        'hospital_id' => $faker->randomElement($hospitals)
    ];
});
