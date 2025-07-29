@extends('rapidez::layouts.app')

@section('title', __('Login as customer'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('content')
    <div class="flex flex-col items-center">
        <h1 class="font-bold text-4xl mb-5">@lang('Login as customer')</h1>

        <login-as-customer v-slot="login" v-cloak>
            <form class="p-8 border rounded w-[400px]" v-on:submit.prevent="login.login">
                <label>
                    <x-rapidez::label>@lang('Admin username')</x-rapidez::label>
                    <x-rapidez::input v-model="login.username" name="username" required/>
                </label>
                <label>
                    <x-rapidez::label>@lang('Admin password')</x-rapidez::label>
                    <x-rapidez::input v-model="login.password" name="password" type="password" required/>
                </label>
                <label>
                    <x-rapidez::label>@lang('Customer email')</x-rapidez::label>
                    <x-rapidez::input v-model="login.customer" name="customer" type="email" required/>
                </label>
                <x-rapidez::button type="submit" class="mt-5">
                    @lang('Login as customer')
                </x-rapidez::button>
            </form>
        </login-as-customer>
    </div>
@endsection
