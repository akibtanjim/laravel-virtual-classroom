<?php

namespace AkibTanjim\VirtualClassRoom;

use AkibTanjim\VirtualClassRoom\ClassRoom;
use Illuminate\Support\ServiceProvider;

class VirtualClassRoomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('virtual-classroom', function () {
            return new ClassRoom();
        });
    }
}
