<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mycss.css') }}">

    @yield('scripts')
    @yield('css')
</head>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Plevoets</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">

                @if (auth()->check())
                    <li><a href="{{ route('klanten.home') }}">Klanten</a></li>


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Facturen <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('facturen.home') }}">Facturen</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('dashboard.home') }}">Facturen opzoeken</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('excel.import') }}">Facturen importeren</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dossiers<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('dossiers.home') }}">Dossiers</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('dossiersexcel.import') }}">Dossiers importeren</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Statistieken<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('dashboard.statistieken') }}">Facturen</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('dashboard.dossiers') }}">Dossiers</a></li>
                        </ul>
                    </li>
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Info<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('bestanden/handleiding.pdf') }}" target="_blank">Handleiding</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="">Factuurmanager V1.0</a></li>
                        <li><a href="http://www.pressd.be" target="_blank">Created by Press'd</a></li>
                    </ul>
                </li>

                <li class="">
                    @if (!auth()->check())
                        <li><a href="{{ route('login') }}">Inloggen</a></li>
                    @else
                        <a href="javascript:;" class="user-profile dropdown-toggle fa fa-user-circle" data-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }} <span class="fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li>
                                
                            
                              
                                <div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Uitloggen') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>

<div class="memory">
    <p>MEMORY USAGE: {{ number_format ( memory_get_usage(true), 0 , "," , "." )}}</p>
</div>
</html>