@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'dashboard'])
@endsection

@section('content')
    DASHBOARD
@endsection