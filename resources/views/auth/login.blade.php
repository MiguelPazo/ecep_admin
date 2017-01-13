@extends('app')

@section('content')
    <div class="container">
        <div class="center-align row">
            <div class="col s12 m6 l4 offset-m3 offset-l4 container-login">
                <h1>ECEP - ADMIN</h1>

                <p>Ingrese con cualquiera de las siguientes opciones:</p>
                <a href="{{ $loginGemalto }}" class="login-gemalto">Ingrese con Proveedor (OP-CF)</a>
                <a id="login_if" href="#" class="login-gemalto">Ingrese con Proveedor (OP - IF)</a>
                <a href="{{ $loginSafelayer }}" class="login-safelayer">Ingrese con Proveedor (MID)</a>
                <a href="{{ $loginSafelayerPass }}" class="login-safelayer">Ingrese con Proveedor (U/P)</a>
                <a href="{{ $loginGoogle }}" class="login-google">Ingrese con Google</a>
                <a href="{{ $loginTwitter }}" class="login-twitter">Ingrese con Twitter</a>
                <a href="{{ $loginLinkedin }}" class="login-linkedin">Ingrese con LinkedIn</a>
                <a href="{{ $loginFacebook }}" class="login-facebook disabled">Ingrese con Facebook</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#login_if').click(function (e) {
                e.preventDefault();

                var authUrl = 'https://idp.reniec.gemalto.com/idp/frontcontroller/openidconnect/authorize';
                var response_type = 'id_token token';
                var client_id = 'ecep_rp';
                var redirect_uri = '{{ pHelper::baseUrl('/end-point/gemalto-auth-if') }}';
                var scope = 'openid';
                var state = Date.now() + "" + Math.random();
                var nonce = "N" + Math.random() + "" + Date.now();

                localStorage.setItem('state', state);
                localStorage.setItem('nonce', nonce);

                var login = authUrl + '?' +
                        'response_type=' + encodeURI(response_type) + '&' +
                        'client_id=' + encodeURI(client_id) + '&' +
                        'redirect_uri=' + encodeURI(redirect_uri) + '&' +
                        'scope=' + encodeURI(scope) + '&' +
                        'state=' + encodeURI(state) + '&' +
                        'nonce=' + encodeURI(nonce);

                location.href = login;
            });
        });
    </script>
@endsection