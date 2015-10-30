<?php

namespace App\Providers;

use App\Extensions\ErsUserProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\UserProvider;

class ErsAuthServiceProvider extends ServiceProvider

{
 /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app['auth']->extend('ers',function($app)
        {
            $model = $app['config']['auth.model'];
            return new ErsUserProvider($app['hash'], $model);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
