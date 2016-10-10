<header class="z-depth-1">
    <div class="logo teal">
        <a href="#">ECEP</a>
    </div>
    <div class="nav-top">
        <ul class="list-unstyled nav-right">
            <li>
                <a data-activates="dp_user" class="dropdown-button waves-effect btn btn-without-shadow btn-user">
                    <div class="chip">
                        <img src="{{ (Session::get('image')) ? Session::get('image') : pHelper::baseUrl('/img/user.jpg')  }}">
                        {{ Session::get('names') }}
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <ul id="dp_user" class="dropdown-content">
        <li>
            <a href="{{ pHelper::baseUrl('/admin/info') }}">Mi Perfil</a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{{ pHelper::baseUrl('/auth/logout') }}">Salir</a>
        </li>
    </ul>
</header>