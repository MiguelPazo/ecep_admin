@extends('app')

@section('content')
    <header class="z-depth-1">
        <div class="logo teal">
            <a href="#">ECEP</a>
        </div>
        <div class="nav-top">
            <ul class="list-unstyled nav-right">
                <li>
                    <a data-activates="dp_user" class="dropdown-button waves-effect btn btn-without-shadow btn-user">
                        <div class="chip">
                            <img src="{{ Session::get('image') }}" alt="Contact Person">
                            {{ Session::get('names') }}
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
                <a href="{{ url('/auth/logout') }}">Salir</a>
            </li>
        </ul>
    </header>
    <div class="main-container">
        @include('__partials.leftsidebar', ['option' => 'dashboard'])
        <div class="content-container">
            <div class="container">
                <div class="row">
                    <div class="col s3 m4 l4">
                        <div class="card">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img class="activator" src="{{ pHelper::baseUrl('/img/monitoreo.svg') }}">
                            </div>
                            <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">
                            Monitoreo<i class="material-icons right">&#xE5D4;</i>
                        </span>

                                <p><a href="{{ pHelper::baseUrlReal('/dashboard/') }}" target="_blank">Ver</a></p>
                            </div>
                            <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">
                            Monitoreo <i class="material-icons right">&#xE14C;</i>
                        </span>

                                <p>Monitoreo de la generación de Certificados Digitales.</p>

                                <p><a href="{{ pHelper::baseUrlReal('/dashboard/') }}" target="_blank">Ver</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection