<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TODO') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">


</head>

<?php
use Illuminate\Support\Facades\Route;
?>

<body class="flex flex-col min-h-screen ">


    <div id="app">
        <header class="bg-blue-900 py-6">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div>
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        {{ config('app.name', 'TODO') }}
                    </a>
                </div>
                <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                    @guest
                    <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                    <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                    @else


                    <div class="topnav" id="myTopnav">
                        <a href="#"></a>
                        <a class="no-underline hover:underline
                                    <?php
                        $getroute = Route::currentRouteName();
                        if ($getroute == 'todo.index') {
                            echo 'active';
                        }
                        ?>" href="{{ route('todo.index') }}">{{ __('My Todos') }}</a>
                        <a class="no-underline hover:underline
                                      <?php
                        $getroute = Route::currentRouteName();
                        if ($getroute == 'post.index') {
                            echo 'active';
                        }
                        ?>" href="{{ route('posts.index') }}">{{ __('Post') }}</a>
                        <a class="image" href="#"> <img class="avatar" src="{{Storage::url(Auth::user()->avatar)}}"
                                alt="Profile"></a>
                        <a href="#"> <span>{{ Auth::user()->name }}</span></a>
                        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                            <i class="fa fa-bars"></i>
                        </a>

                        <a href="{{ route('logout') }}" class="no-underline hover:underline" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>


                    </div>

                    @endguest
            </div>
        </header>
    
    

    <div class="flex-grow ml-4 mr-4 ">
        @yield('content')
    </div>

    {{-- <footer class="bg-gray-100 text-center lg:text-left mt-5 ">


        <div class="text-center text-gray-700 p-14">
            © 2022 Copyright:
            <a class="text-gray-800" href="TODO APP CHALLENGE</a>">Todo App </a>
        </div>
    </footer> --}}
    
    

</body>
<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }

</script>
<script src="{{ asset('js/index.js') }}" defer></script>
<script src="sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

</html>
