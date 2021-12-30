@extends('layouts.app')

@section('title', 'Eventful')

@section('content')

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
