<?php

namespace Rapidez\LoginAsCustomer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SignedLoginAsCustomerController
{
    public function __invoke(Request $request)
    {
        $cache = Cache::store(config('cache.default'));
        if (! $request->hasValidSignature() || ! $cache->has('login-as-customer-' . $request->get('key'))) {
            return redirect()->route('login-as-customer');
        }

        $data = $cache->get('login-as-customer-' . $request->get('key'));
        $cache->forget('login-as-customer-' . $request->get('key'));

        if (! config('rapidez.models.customer')::whereToken($data['token'])->exists()) {
            return redirect()->route('login-as-customer');
        }

        return view('rapidez::login-as-customer', ['token' => $data['token']]);
    }
}
