@extends("app")

@section("content")
    <header class="z-depth-1">
        <div class="logo teal">
            <a href="#">ECEP</a>
        </div>
        <div class="nav-top">
            <ul class="list-unstyled nav-right">
                <li>
                    <a data-activates="dp_user" class="dropdown-button waves-effect btn btn-without-shadow btn-user">
                        <div class="chip" id="name">

                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <ul id="dp_user" class="dropdown-content">
            <li>
                <a href="{{ pHelper::baseUrl("/auth/logout") }}">Salir</a>
            </li>
        </ul>
    </header>
    <div class="main-container">
        <div class="content-container">
            <div class="container">
                <div class="row">
                    <div class="col s12" id="user_info">

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section("scripts")
    <script>
        $(document).ready(function () {
            var hash = window.location.hash.substr(1);
            var result = hash.split('&').reduce(function (result, item) {
                var parts = item.split('=');
                result[parts[0]] = parts[1];
                return result;
            }, {});
            var decodeJWT = function (idToken) {
                var base64Url = idToken.split('.')[1];
                var base64 = base64Url.replace('-', '+').replace('_', '/');
                return JSON.parse(window.atob(base64));
            }

            if (!result.error) {
                if (result.state == localStorage.getItem('state')) {
                    var token = result.access_token;
                    var idToken = result.id_token;
                    var data = decodeJWT(idToken);

                    console.log(token);
                    console.log(idToken);
                    console.log(data);

                    if (data.nonce = localStorage.getItem('nonce')) {
                        var userInfo = 'https://idp.reniec.gemalto.com/idp/frontcontroller/openidconnect/userinfo';

                        $.ajax({
                            type: 'GET',
                            url: userInfo,
                            dataType: 'json',
                            async: false,
                            headers: {
                                'Authorization': 'Bearer ' + token
                            },
                            success: function (response) {
                                $('#name').text('Identificado');
                                $('#user_info').text(response);
                                console.log(response);
                            },
                            error: function (response) {
                                $('#name').text('No Identificado');
                                console.log(response);
                            }
                        });
                    } else {
                        console.log('Error nonce');
                        location.href = '{{ pHelper::baseUrl('/') }}';
                    }
                } else {
                    console.log('Error state');
                    location.href = '{{ pHelper::baseUrl('/') }}';
                }
            } else {
                console.log('Error');
                location.href = '{{ pHelper::baseUrl('/') }}';
            }
        });
    </script>
@endsection