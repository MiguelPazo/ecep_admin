@extends('app')

@section('content')
    <div class="container">
        <div class="center-align row">
            <div class="col s12 m6 l4 offset-m3 offset-l4 container-login">
                <h1>ECEP - ADMIN</h1>
                <p>Ingrese con cualquiera de las siguientes opciones:</p>
                <a href="#" class="login-dnie">Ingrese con DNIe</a>
                <a href="{{ $loginGoogle }}" class="login-google">Ingrese con Google</a>
                <a href="{{ $loginFacebook }}" class="login-facebook">Ingrese con Facebook</a>
                <a href="{{ $loginTwitter }}" class="login-twitter">Ingrese con Twitter</a>
                <a href="{{ $loginLinkedin }}" class="login-linkedin">Ingrese con LinkedIn</a>
            </div>
        </div>
    </div>
@endsection