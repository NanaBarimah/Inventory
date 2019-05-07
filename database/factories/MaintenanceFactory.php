<?php

use Faker\Generator as Faker;

$factory->define(App\Maintenance::class, function (Faker $faker) {
    $equipment = App\Equipment::pluck('code')->toArray();
    $user_id = App\User::pluck('id')->toArray();
    $admin_id = App\Admin::pluck('id')->toArray();
    $new_array = array();

    foreach($user_id as $single){
        array_push($new_array, $single);
    }

    foreach($admin_id as $single){
        array_push($new_array, $single);
    }

    $type = ['Planned Maintenance', 'Corrective Maintenance', 'Emergency Maintenance'];
    $type = $type[rand(0, 2)];
    
    if($type == 'Planned Maintenance'){
        return [
            'action_taken' => $faker->paragraph,
            'recommendation' => $faker->paragraph,
            'equipment_code' => $faker->randomElement($equipment),
            'type' => 'Planned Maintenance', 
            'mtce_officer' => $faker->randomElement($new_array),
            'cost' => 200,
            'date_inspected' => $faker->date,
            'down_time' => $faker->randomDigit,
            'duration_units' => 'Hours',
            'duration' => '10 hours',
            'faulty_category' => 'Damaged',
            'problem_found' => $faker->paragraph,
            'reason' => $faker->paragraph,
            'recommendation' => $faker->paragraph,
            'job_number' => '3',
            'function_check' => 1,
            'safety_check' => 1,
            'calibration_check' => 1
        ];
    }else if($type == 'Corrective Maintenance' || 'Emergency Maintenance'){
        return [
            'action_taken' => $faker->paragraph,
            'recommendation' => $faker->paragraph,
            'equipment_code' => $faker->randomElement($equipment),
            'type' => $type, 
            'mtce_officer' => $faker->randomElement($new_array),
            'cost' => 200,
            'date_inspected' => $faker->date,
            'date_reported' => $faker->date,
            'down_time' => $faker->randomDigit,
            'duration_units' => 'Hours',
            'duration' => '10 hours',
            'faulty_category' => 'Damaged',
            'problem_found' => $faker->paragraph,
            'reason' => $faker->paragraph,
            'recommendation' => $faker->paragraph,
            'date_out' => $faker->dateTime,
            'job_number' => '3',
            'function_check' => 1,
            'safety_check' => 1,
            'calibration_check' => 1
        ];
    }
   
});
