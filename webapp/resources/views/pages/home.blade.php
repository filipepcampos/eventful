@extends('layouts.base')

@section('title', 'Eventful')

@section('content')
<script type="text/javascript" src="{{ asset('/js/requestsManagement.js') }}" ></script>
<div class="container">
    <div class="row justify-content-center my-5">
        <h1 class="homepage-title text-center"> Eventful </h1>
        <p class="lead text-center">An event platform for all your needs</p>
    </div>
    <div class="row justify-content-center">
        @each('partials.eventCard', $events, 'event')
    </div>
    <div class="row justify-content-center">
        {{ $events->render() }}
    </div>
</div>

@endsection
