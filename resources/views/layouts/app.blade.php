<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'diepxuan.com') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">


        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'DiepXuan Company') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name ? Auth::user()->name : Auth::user()->username }} <span
                                    class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @guest
        <main class="py-4">
            @yield('content')
        </main>
        @else

        <div class="container-fluid">
            <div class="row">
                <div id="sidebar" class="navbar navbar-dark bg-dark col-md-2 align-items-start p-0">
                    <!-- sidebar-brand  -->
                    <!-- sidebar-header  -->
                    <!-- sidebar-search  -->
                    <!-- sidebar-menu  -->
                    <ul class="sidebar-menu nav flex-column border-top w-100">
                        <li class="nav-item">
                            <a class="nav-link text-muted d-flex justify-content-between align-items-center"
                                data-toggle="collapse" data-target="#dashboardCollapse" aria-expanded="false"
                                href="javascript:void(0)">
                                <span>{{ __('Dashboard') }}</span>
                                <i class="fa fa-chevron-right"></i>
                            </a>
                            <div class="collapse" id="dashboardCollapse">
                                <ul>
                                    <li>
                                        <a class="text-decoration-none text-light"
                                            href="{{ route('admin.salary') }}">{{ __('Salary') }}</a>
                                    </li>
                                    @yield('sidebar.salary')
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <!-- sidebar-footer  -->
                </div>

                <main class="col-md-10 py-4">
                    @yield('content')
                </main>
            </div>
        </div>

        @endguest
    </div>
</body>

</html>
