<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         /*factory(App\Region::class, 10)->create()->each(function($admin){
            $admin->admins()
                  ->saveMany(
                      factory(App\Admin::class, 1)->make()
                  );
        });*/
        
        /*factory(App\District::class, 30)->create()->each(function($d){
            $d->hospitals()
              ->saveMany(
                factory(App\Hospital::class, 1)->create()->each(function($u){
                    $u->users()
                      ->saveMany(
                        factory(App\User::class, 1)->make()
                      );
                })
              );
        });*/
        //factory(App\User::class, 30)->create();

        /*factory(App\Service_Vendor::class, rand(1,30))->create();
        factory(App\Category::class, 30)->create();
        factory(App\Department::class, 30)->create();
        factory(App\Unit::class, 30)->create();
        factory(App\Service_Vendor::class, 400)->create();
        factory(App\Equipment::class, 2000)->create();
        factory(App\Maintenance::class, 2000)->create();*/

        factory(App\Requests::class, 200)->create()->each(function($equip){
            $equip->equipment_requests()
                  ->saveMany(
                      factory(App\Equipment_request::class, 2)->make()
                  );
        });
       
    }
}
