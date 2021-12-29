@extends('layouts.app')

@section('title', 'Home')

@section('content')

<h1 class="display-1 text-center my-5"> Eventful </h1>

<div class="row justify-content-center">
    @each('partials.eventCard', $events, 'event')
</div>

@endsection
