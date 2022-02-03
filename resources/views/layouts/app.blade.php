<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
    <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<?php
use Illuminate\Support\Facades\Route;
?>

<body  class="bg-gray-100 h-screen antialiased leading-none font-sans   flex flex-col min-h-screen">

<div id="app">
    <div>
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

                        <div class="Navbar">

                            <div class="Navbar__Link Navbar__Link-toggle" onclick="classToggle">
                                <i class="fas fa-bars"></i>
                            </div>
                            <nav class="Navbar__Items">
                                <div class="Navbar__Link">
                                    <a class="no-underline hover:underline
                                <?php
                                    $getroute = Route::currentRouteName();
                                    if ($getroute == 'todo.index') {
                                        echo 'active';
                                    }
                                    ?>"

                                       href="{{ route('todo.index') }}">{{ __('My Todos') }}</a>
                                </div>
                                <div class="Navbar__Link">
                                    <a class="no-underline hover:underline
                                      <?php
                                    $getroute = Route::currentRouteName();
                                    if ($getroute == 'post.index') {
                                        echo 'active';
                                    }
                                    ?>"
                                       href="{{ route('posts.index') }}">{{ __('Post') }}</a>
                                </div>


                                <div class="Navbar__Link ml-10">
                                    <img class="avatar" src="{{Storage::url(Auth::user()->avatar)}}" alt="Profile">

                                </div>

                                <div class="Navbar__Link">

                                    <span>{{ Auth::user()->name }}</span>
                                </div>
                            </nav>
                            <nav class="Navbar__Items Navbar__Items--right">

                                <div class="Navbar__Link">
                                    <a href="{{ route('logout') }}"
                                       class="no-underline hover:underline"
                                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        {{ csrf_field() }}
                                    </form>


                                </div>

                            </nav>

                            @endguest
                        </div>


                </nav>
            </div>
        </header>


    </div>

    <div class="flex-grow">

        @yield('content')
    </div>

    <footer class="bg-gray-100 text-center lg:text-left mt-5 ">


        <div class="text-center text-gray-700 p-14" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright:
            <a class="text-gray-800" href="https://tailwinO APP CHALLENGE</a>d-elements.com/">Todo App </a>
        </div>
    </footer>
</div>




<script>
    function classToggle() {
        const navs = document.querySelectorAll('.Navbar__Items')

        navs.forEach(nav => nav.classList.toggle('Navbar__ToggleShow'));
    }

    document.querySelector('.Navbar__Link-toggle')
        .addEventListener('click', classToggle);
</script>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>





