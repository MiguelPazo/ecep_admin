@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'product'])
@endsection

@section('content')
    <div class="container" data-ng-controller="categoryController">
        <h4>Editar Categoría: "CATEGORIA"</h4>

        <form id="categoryForm" action="">
            @include('category.__partials.form')
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/app/controllers/categoryController.js') }}"></script>
    <script src="{{ asset('/js/app/service/categoryService.js') }}"></script>
@endsection