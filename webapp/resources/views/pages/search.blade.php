@extends('layouts.base')

@section('title', 'Eventful - Search')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('homepage') }}">Home</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('events') }}">Events</a></li>
<li class="breadcrumb-item active" aria-current="page">Search</li>
@endsection

@section('content')
<h1 class="text-center my-5">Searching for: {{ $search }}</h1>
<div class="row">
    <div class="col-2">
        <div class="card mx-5">
            <h2 class="card-title mx-3 my-3">Tags:</h2>
            <div class="card-body mx-3">
                <form method="GET" action="{{ url('event') }}" class="mb-3">
                    <input type="hidden" name="search" value="{{ $search }}">
                    @foreach ($tags as $tag)
                        @include('partials.tag', ['selected' => $tagsSelected])
                    @endforeach
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row justify-content-center">
            @each('partials.eventCard', $events, 'event')
        </div>
    </div>
</div>
@endsection