<!DOCTYPE HTML>
<!--[if lt IE 8]>
<html class="no-js lt-ie8" data-ng-app="ecep"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" data-ng-app="ecep"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
    <title>ECEP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link type="text/css" rel="stylesheet" media="screen,projection"
          href="{{ pHelper::baseUrl('/js/libs/materialize/dist/css/materialize.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ pHelper::baseUrl('/css/main.css') }}">

    <link rel="shortcut icon" href="img/icon.png'">
</head>
<body>
<!--[if lt IE 9]>
<div class="lt-ie9-bg">
    <p class="browsehappy">Estas usando un navegador <strong>muy antiguo</strong>
        <a href="http://browsehappy.com/">actualizate</a>, vive una mejor experiencia y se feliz :D</p>
</div>
<![endif]-->

<div class="progress hide">
    <div class="indeterminate green"></div>
</div>
<header class="z-depth-1">
    <div class="logo teal">
        <a href="#">ECEP</a>
    </div>
    <div class="nav-top">
        {{--<ul class="list-unstyled nav-left">--}}
        {{--<li class="hide-on-small-only">--}}
        {{--<a class="waves-effect btn btn-without-shadow">--}}
        {{--<i class="material-icons">&#xE8FE;</i>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li class="hide-on-small-only">--}}
        {{--<a class="waves-effect btn btn-without-shadow">--}}
        {{--<i class="material-icons">&#xE8B8;</i>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li class="hide-on-small-only">--}}
        {{--<a class="waves-effect btn btn-without-shadow">--}}
        {{--<i class="material-icons">&#xE8B6;</i>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        <ul class="list-unstyled nav-right">
            <li>
                <a data-activates="dp_user" class="dropdown-button waves-effect btn btn-without-shadow btn-user">
                    <div class="chip">
                        <img src="{{ pHelper::baseUrl('/img/user.jpg') }}" alt="Contact Person">
                        {{ $names}}
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <ul id="dp_user" class="dropdown-content">
        <li>
            <a href="#!">Mi Perfil</a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="#!">Salir</a>
        </li>
    </ul>
</header>
<div class="main-container">
    @yield('leftsidebar')
    <div class="content-container">
        @yield('content')
    </div>
</div>
<script src="{{ pHelper::baseUrl('/js/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ pHelper::baseUrl('/js/libs/materialize/dist/js/materialize.min.js') }}"></script>
<script src="{{ pHelper::baseUrl('/js/libs/angular/angular.min.js') }}"></script>
<script src="{{ pHelper::baseUrl('/js/app/app.js') }}"></script>
@yield('scripts')
</body>
</html>
