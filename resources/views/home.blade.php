@extends('layouts.app')

    @section('content')  
    @auth
        <router-view :user-i-d="{{ Auth::user()->id }}"></router-view>
    @endauth
    @guest
        <div class="uk-container">
            <div class="uk-margin">
                <div class="uk-flex uk-flex-column uk-flex-left">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}">Войти</a>
                    @endif
                    <span> или </span>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"> Зарегистрироваться</a>
                    @endif
                </div>
            </div>
        </div>
    @endguest

    <vue-progress-bar></vue-progress-bar>

    @endsection