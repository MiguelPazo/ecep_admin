@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'category'])
@endsection

@section('content')
    <div class="row">
        @for($i = 0; $i<21;$i++)
            <div class="col s6 m4 l3">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="{{ asset('/img/product.jpg') }}">
                    </div>
                    <div class="card-content">
                                <span class="card-title activator grey-text text-darken-4">
                                    Categoría {{ $i + 1 }}
                                    <i class="material-icons right">more_vert</i>
                                </span>
                    </div>
                    <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4">
                                    Card Title
                                    <i class="material-icons right">close</i></span>

                        <p>Descripción de la categoría</p>

                        <p>Total de Productos: </p>

                        <div class="card-options">
                            <a class="btn-floating btn waves-effect waves-light blue right">
                                <i class="material-icons">&#xE150;</i>
                            </a>

                            <a class="btn-floating btn waves-effect waves-light red right">
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
    <a class="btn-floating btn-large waves-effect waves-light red btn-new"><i class="material-icons">add</i></a>
@endsection