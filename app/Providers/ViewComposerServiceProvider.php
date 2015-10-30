<?php

namespace App\Providers;

use App\Article;
use Illuminate\Support\ServiceProvider;
use App\Http\Composers\NavigationComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->composeNavigation();

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

    /**
     * Compose the navigation bar
     */
    private function composeNavigation()
    {
        view()->composer('navbar', 'App\Http\Composers\NavigationComposer');
    }
}
