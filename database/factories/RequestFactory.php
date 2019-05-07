<?php

use Faker\Generator as Faker;

$factory->define(App\Requests::class, function (Faker $faker) {
    $type = ['Planned Maintenance', 'Corrective Maintenance', 'Emergency Maintenance'];
    $type = $type[rand(0, 2)];

    $equipment_code = App\Equipment::pluck('code')->toArray();
    return [
        'maintenance_type' => $type,
        //'equipment_code' => $faker->randomElement($equipment_code),
        'description' => $faker->paragraph
    ];
});
