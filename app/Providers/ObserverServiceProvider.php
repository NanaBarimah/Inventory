<?php

namespace App\Providers;

use App\User;
use App\Admin;
use App\Observers\AdminObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //User::observe(UserObserver::class);
        //Admin::observe(AdminObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
