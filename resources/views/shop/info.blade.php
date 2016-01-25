@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'shop'])
@endsection

@section('content')
    <div class="container" data-ng-controller="shopController">
        <h4>Datos de la Tienda</h4>

        <form id="productForm" action="">
            <div class="row z-depth-1 grey lighten-5 form-new">
                <div class="col s12">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">&#xE22B;</i>
                        <input id="alias" type="text" class="validate">
                        <label for="alias">Alias</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">&#xE253;</i>
                        <textarea id="description" class="materialize-textarea"></textarea>
                        <label for="description">Descripción</label>
                    </div>
                    <div class="btn-options right">
                        <button type="submit" class=" modal-action modal-close waves-effect waves-light btn">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/app/controllers/shopController.js') }}"></script>
    <script src="{{ asset('/js/app/service/shopService.js') }}"></script>
@endsection