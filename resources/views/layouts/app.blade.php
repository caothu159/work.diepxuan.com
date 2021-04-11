<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'diepxuan.com') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') . '?v=' . uniqid() }}" defer></script>

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" href="favicon.png" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') . '?v=' . uniqid() }}" rel="stylesheet">
</head>

<body class="d-none">
    <div id="app">

        <nav class="navbar navbar-expand-md">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ "Bảng Lương" }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @yield('menu.left')
                    </ul>

                    @yield('menu.center')
                    <!-- Middle Side Of Navbar -->

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

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if(isset($controller) && $controller->isAdmin())

        <div class="container-fluid">
            <div class="row">
                <ul id="sidebar" class="sidebar col-md-2">
                    <li>
                        <a class="text-decoration-none{{ Request()->is('salary*')?' font-weight-bold':'' }}"
                            href="{{ route('salary.index') }}">
                            {{ __('salary.salary') }}
                        </a>
                        @yield('sidebar.salary')
                    </li>
                    <li>
                        <a class="text-decoration-none{{ Request()->is('users*')?' font-weight-bold':'' }}"
                            href="{{ route('users.index') }}">
                            {{ __('user.manager') }}
                        </a>
                        @yield('sidebar.user')
                    </li>
                </ul>

                <main class="col-md-10">
                    @yield('content')
                </main>
            </div>
        </div>

        @else

        <main class="container-fluid">
            @yield('content')
        </main>

        @endif
    </div>

    @if(isset($controller) && $controller->isAdmin())
    @php
    $renderer = Debugbar::getJavascriptRenderer();
    @endphp
    {!! $renderer->renderHead() !!}
    {!! $renderer->render() !!}
    @endif
</body>

</html>
