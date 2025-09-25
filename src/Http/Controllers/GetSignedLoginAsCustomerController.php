<?php

namespace Rapidez\LoginAsCustomer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class GetSignedLoginAsCustomerController
{
    /**
     * Time for the signed route to be valid for, 2 minutes will result in a timeout anyways.
     * So it's better to remove the token after that time.
     */
    public const URL_TIMEOUT = 120;

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'token' => 'required',
        ]);
        $cachekey = (string) Str::uuid();
        Cache::store(config('cache.default'))->put('login-as-customer-' . $cachekey, $data, static::URL_TIMEOUT);

        return ['url' => URL::signedRoute('signed-login-as-customer', ['key' => $cachekey], static::URL_TIMEOUT)];
    }
}
