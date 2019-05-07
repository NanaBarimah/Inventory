<?php

use Faker\Generator as Faker;

$factory->define(App\Equipment::class, function (Faker $faker) {
    $categories = App\Category::pluck('id')->toArray();
    $hospitals = App\Hospital::pluck('id')->toArray();
    $users = App\User::pluck('id')->toArray();
    $units = App\Unit::pluck('id')->toArray();
    $services = App\Service_Vendor::pluck('id')->toArray();

    return [
        'code' => $faker->swiftBicNumber,
        'serial_number' => $faker->isbn10,
        'model_number' => $faker->isbn13,
        'manufacturer_name' => $faker->company,
        'description' => $faker->paragraph,
        'category_id' => $faker->randomElement($categories),
        'status' => 'Good',
        'hospital_id' => $faker->randomElement($hospitals),
        'user_id' => $faker->randomElement($users),
        'maintenance_frequency' => 5,
        'unit_id' => $faker->randomElement($units),
        'location' => 'Balcony',
        'year_of_purchase' => $faker->year,
        'installation_time' => $faker->date,
        'pos_rep_date' => $faker->date,
        'equipment_cost' => $faker->numberBetween,
        'service_vendor_id' => $faker->randomElement($services)
    ];
});
