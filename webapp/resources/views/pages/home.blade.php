@extends('layouts.base')

@section('title', 'Eventful')

@section('content')
<script type="text/javascript" src="{{ asset('/js/requestsManagement.js') }}" ></script>
<div class="container">
    <div class="row justify-content-center">
        <h1 class="homepage-title text-center my-5"> Eventful </h1>
    </div>
    <div class="row justify-content-center">
        @each('partials.eventCard', $events, 'event')
    </div>
    <div class="row justify-content-center">
        {{ $events->render() }}
    </div>
</div>

@endsection
