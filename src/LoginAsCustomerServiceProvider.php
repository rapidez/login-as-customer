<?php

namespace Rapidez\LoginAsCustomer;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LoginAsCustomerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez'),
        ], 'views');

        Route::view('login-as-customer', 'rapidez::login-as-customer');
    }
}
