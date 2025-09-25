<?php

use Illuminate\Support\Facades\Route;
use Rapidez\LoginAsCustomer\Http\Controllers\GetSignedLoginAsCustomerController;

Route::middleware('api')->prefix('api')->group(function () {
    Route::post('get-login-as-customer-url', GetSignedLoginAsCustomerController::class);
});
