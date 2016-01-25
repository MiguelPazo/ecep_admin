<aside class="nav-container">
    <ul>
        <li class="nav-title">Navegación</li>
        <li class="{{ ($option == 'dashboard')? 'active' : '' }}">
            <a href="{{ url('admin/') }}" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE88A;</i>Resumen
            </a>
        </li>
        <li class="{{ ($option == 'shop')? 'active' : '' }}">
            <a href="{{ url('admin/shop/') }}" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE8D1;</i>Tienda
            </a>
        </li>
        <li class="{{ ($option == 'category')? 'active' : '' }}">
            <a href="{{ url('admin/category/') }}" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE886;</i>Categorias
            </a>
        </li>
        <li class="{{ ($option == 'product')? 'active' : '' }}">
            <a href="{{ url('admin/product/') }}" class="waves-effect waves-light btn btn-without-shadow">
                <i class="material-icons">&#xE0E0;</i>Productos
            </a>
        </li>
        <li class="nav-divider"></li>
    </ul>
</aside>