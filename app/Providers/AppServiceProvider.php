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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // In production the app is served over HTTPS via an SSL-terminating
        // proxy. Force every generated URL (route(), asset(), url()) to https
        // so form actions and assets are never emitted as insecure http://,
        // which otherwise triggers "not secure" warnings and 405 errors on POST.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
