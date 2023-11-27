<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        View::composer('partials._groups', function ($view) use ($auth) {
            if (!$auth->check()) {
                return;
            }

            $view->with('groups', $auth->user()->groups()->get());
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
