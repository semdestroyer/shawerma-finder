<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TelegramView extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        App::bind("telegramview", function (){
            return new TelegramView;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
