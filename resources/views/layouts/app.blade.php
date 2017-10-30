<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIP-RANDIS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('dt-css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg justify-content-between bg-navy-blue">
            @auth
                <a class="navbar-brand nav-link text-white" href="{{ route('home') }}" style="padding-left: 0.3em">
            @else
                <a class="navbar-brand nav-link text-white" href="{{ url('/') }}" style="padding-left: 0.3em">
            @endauth
                {{ config('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
        <nav class="navbar navbar-expand-lg justify-content-between bg-light" style="margin-bottom: 2em">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mr-2">
                        <a class="nav-link" href="{{ route('employee.index') }}">
                            <i class="fa fa-group" aria-hidden="true"></i> Data Pegawai
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('car.index') }}">
                            <i class="fa fa-car" aria-hidden="true"></i> Data Mobil
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('driver.index') }}">
                            <i class="fa fa-drivers-license" aria-hidden="true"></i> Data Sopir
                        </a>
                    </li>
                </ul>
                @endauth
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown float-right">
                        @if (Auth::guest())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        @endif
                    </li>
                </ul>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    @stack('dt')

    @include('sweet::alert')
</body>
</html>
