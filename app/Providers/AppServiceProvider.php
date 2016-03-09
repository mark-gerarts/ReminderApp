<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\User\IUserRepository', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Repositories\Contact\IContactRepository', 'App\Repositories\Contact\ContactRepository');
        $this->app->bind('App\Repositories\Quick_reminder\IQuick_reminderRepository', 'App\Repositories\Quick_reminder\Quick_reminderRepository');
        $this->app->bind('App\Repositories\User_order\IUser_orderRepository', 'App\Repositories\User_order\User_orderRepository');
        $this->app->bind('App\Repositories\User_reminder\IUser_reminderRepository', 'App\Repositories\User_reminder\User_reminderRepository');
    }
}
