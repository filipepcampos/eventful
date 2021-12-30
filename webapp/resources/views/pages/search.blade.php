@extends('layouts.app')

@section('title', 'Search')

@section('content')
<h1 class="text-center my-5">Searching for: {{ $search }}</h1>
<div class="row">
    <div class="col-2">
        <div class="card mx-5">
            <h2 class="card-title">Tags:</h2>
            <form method="GET" action="{{ url('event') }}">
                <input type="hidden" name="search" value="{{ $search }}">
                @each('partials.tag', $tags, 'tag')
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="col">
        <div class="row justify-content-center">
            @each('partials.eventCard', $events, 'event')
        </div>
    </div>
</div>
@endsection