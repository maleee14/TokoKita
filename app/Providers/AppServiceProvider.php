<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        view()->composer('layouts.master', function ($view) {
            $view->with('setting', Setting::first()->first());
        });
        view()->composer('layouts.auth', function ($view) {
            $view->with('setting', Setting::first()->first());
        });
        view()->composer('auth.login', function ($view) {
            $view->with('setting', Setting::first()->first());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
