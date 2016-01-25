@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'product'])
@endsection

@section('content')
    <div class="container" data-ng-controller="productController">
        <div class="row">
            @for($i = 1; $i<21;$i++)
                <div class="col s4 m3 l2">
                    <div class="card card-product">
                        <div class="card-image">
                            <img src="{{ asset('/img/product.jpg') }}">
                        </div>
                        <div class="card-content">
                            <p>Producto {{ $i + 1 }}</p>

                        </div>
                        <div class="card-action">
                            <span class="price">S/. 256.00</span>

                            <div class="card-options">
                                <a href="{{ route('admin.product.edit', $i) }}"
                                   class="btn-floating btn waves-effect waves-light blue right">
                                    <i class="material-icons">&#xE150;</i>
                                </a>

                                <a class="btn-floating btn waves-effect waves-light grey right"
                                   data-ng-click="deleteProduct({{ $i }}, 'Producto {{ $i }}')">
                                    <i class="material-icons">&#xE872;</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <ul class="pagination">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            <li class="active"><a href="#!">1</a></li>
            <li class="waves-effect"><a href="#!">2</a></li>
            <li class="waves-effect"><a href="#!">3</a></li>
            <li class="waves-effect"><a href="#!">4</a></li>
            <li class="waves-effect"><a href="#!">5</a></li>
            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
        <a href="{{ route('admin.product.create') }}"
           class="btn-floating btn-large waves-effect waves-light red btn-new">
            <i class="material-icons">add</i>
        </a>
        @include('__partials.modaldelete')
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/app/controllers/productController.js') }}"></script>
    <script src="{{ asset('/js/app/service/productService.js') }}"></script>
@endsection