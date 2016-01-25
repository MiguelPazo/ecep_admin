@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'product'])
@endsection

@section('content')
    <div class="container" data-ng-controller="productController">
        <h4>Nuevo Producto</h4>

        <form id="productForm" action="">
            @include('product.__partials.form')
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/app/controllers/productController.js') }}"></script>
    <script src="{{ asset('/js/app/service/productService.js') }}"></script>
@endsection