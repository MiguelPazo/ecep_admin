@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'dashboard'])
@endsection

@section('content')
    <div class="container">
        DASHBOARD
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/app/controllers/dashboardController.js') }}"></script>
    <script src="{{ asset('/js/app/service/dashboardService.js') }}"></script>
@endsection