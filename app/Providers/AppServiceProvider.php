<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Share cart count globally with all views
        view()->composer('*', function ($view) {
            $view->with('cartCount', count(session()->get('cart', [])));
        });
    }
}
