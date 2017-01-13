@extends('app')

@section('content')

    @include('__partials.header')

    <div class="main-container">
        @include('__partials.leftsidebar', ['option' => 'dashboard'])

        <div class="content-container">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <?php
                        $localLabels = ['provider' => 'Proveedor: ', 'names' => 'Nombres: ', 'lastnames' => 'Apellidos: ',
                                'birthdate' => 'Fec. Nac.: ', 'gender' => 'Genero: ', 'country' => 'País: ',
                                'state' => 'Estado: ', 'city' => 'Lima: ', 'street' => 'Calle: ', 'email' => 'E-mail: '];
                        $data = json_decode(Session::get('data'), true);
                        ?>
                        <h1>INFORMACIÓN DEL USUARIO</h1>

                        @foreach($data as $key => $value)
                            @if($value != '' && array_key_exists($key, $localLabels))
                                <p>{{ $localLabels[$key] }} <b>{{ $value }}</b></p>
                            @endif
                        @endforeach

                        @if($data['all'])
                            <pre>
                                <?php
                                echo json_encode($data['all'], JSON_PRETTY_PRINT);
                                ?>
                            </pre>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection