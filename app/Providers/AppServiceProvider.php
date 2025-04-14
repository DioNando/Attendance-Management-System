<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Force HTTPS in production
        // if ($this->app->environment('production')) {
        //     URL::forceScheme('https');
        // }

        // Register any application services here
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
