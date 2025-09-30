<?php

use Illuminate\Support\Facades\Route;
use Rapidez\LoginAsCustomer\Http\Controllers\SignedLoginAsCustomerController;

Route::middleware('web')->group(function () {
    Route::get('login-as-customer/signed', SignedLoginAsCustomerController::class)->name('signed-login-as-customer');
    Route::view('login-as-customer', 'rapidez::login-as-customer')->name('login-as-customer');
});
