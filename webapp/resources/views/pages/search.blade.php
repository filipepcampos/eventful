@extends('layouts.app')

@section('title', 'Search')

@section('content')
<h1 class="text-center my-5">Searching for: {{ $search }}</h1>
<div class="row justify-content-center">
    <div class="col-auto mb-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Tags</h2>
                @each('partials.tags', $events, 'event')
            </div>
        </div>
    </div>
    @each('partials.eventCard', $events, 'event')
</div>
@endsection
