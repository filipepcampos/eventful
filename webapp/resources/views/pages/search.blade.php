@extends('layouts.app')

@section('title', 'Search')

@section('content')
<h1 class="text-center my-5">Searching for: {{ $search }}</h1>
<div class="row justify-content-center">
    @each('partials.eventCard', $events, 'event')
</div>
@endsection
