@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'dashboard'])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s3 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="img/monitoreo.svg">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">
                            Monitoreo<i class="material-icons right">more_vert</i>
                        </span>
                        <p><a href="https://pki.reniec.gob.pe/dashboard/" target="_blank">Ver</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">
                            Monitoreo <i class="material-icons right">close</i>
                        </span>
                        <p>Monitoreo de la generación de Certificados Digitales.</p>
                        <p><a href="https://pki.reniec.gob.pe/dashboard/" target="_blank">Ver</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="js/app/controllers/dashboardController.js"></script>
    <script src="js/app/service/dashboardService.js"></script>
@endsection