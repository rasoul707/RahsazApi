<?php

namespace App\Providers;

use App\Channels\FarazSMSChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* FarazSMS Channel */
        Notification::extend('farazsms', function ($app) {
            return new FarazSMSChannel();
        });
    }
}
