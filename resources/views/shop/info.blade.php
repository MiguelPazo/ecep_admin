@extends('app')

@section('leftsidebar')
    @include('__partials.leftsidebar', ['option' => 'shop'])
@endsection

@section('content')
    STORE
@endsection