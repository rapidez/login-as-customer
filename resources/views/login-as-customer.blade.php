@extends('rapidez::layouts.app')

@section('title', __('Login as customer'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('content')
    <div class="flex flex-col items-center">
        <h1 class="font-bold text-4xl mb-5">@lang('Login as customer')</h1>
        @if($token ?? '')
            <login-as-customer-by-token token="{{ $token }}" v-slot="{ processing }">
                <div v-cloak v-if="processing" class="bg-black bg-opacity-50 z-50 fixed inset-0 flex justify-items-center items-center">
                    <div class="flex-row justify-items-center items-center mx-auto">
                        <x-heroicon-o-arrow-path class="text-white mx-auto size-10 animate-spin" />
                        <span class="text-white">@lang('Logging in...')</span>
                    </div>
                </div>
            </login-as-customer-by-token>
        @endif

        <login-as-customer v-slot="{ inputChange, login }" v-cloak>
            <form class="p-8 border rounded w-[400px]" v-on:submit.prevent="login">
                <x-rapidez::input v-on:input="inputChange" name="username" label="Admin username" required/>
                <x-rapidez::input v-on:input="inputChange" name="password" label="Admin password" type="password" required/>
                <x-rapidez::input v-on:input="inputChange" name="customer" label="Customer email" type="email" required/>
                <x-rapidez::button type="submit" class="mt-5">
                    @lang('Login as customer')
                </x-rapidez::button>
            </form>
        </login-as-customer>
    </div>
@endsection
