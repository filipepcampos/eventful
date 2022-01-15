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
            <h2 class="card-title mx-3 mt-3 mb-2">Filters</h2>
            <div class="card-body mx-3 my-0 px-0 py-0">
                <form method="GET" action="{{ url('event') }}">
                    <div class="form-group mb-3">
                        <input type="hidden" name="search" value="{{ $search }}">

                        <fieldset>
                            <legend>Tags</legend>
                            @foreach ($tags as $tag)
                                @include('partials.tag', ['selected' => $tagsSelected])
                            @endforeach
                        </fieldset>

                        <label for="after_date" class="form-label font-weight-bold">After</label>
                        <input id="after_date" type="datetime-local" name="after" class="form-control" value="{{ $after_date }}">

                        <label for="before_date" class="form-label">Before</label>
                        <input id="before_date" type="datetime-local" name="before" class="form-control" value="{{ $before_date }}">
                    </div>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row justify-content-center">
            @each('partials.eventCard', $events, 'event')
            @forelse($events as $event)
                @include('partials.eventCard', ['event' => $event])
            @empty
                <h3 class="w-50">No event matches your criteria, try tweaking the search parameters</h3>
            @endforelse
        </div>
    </div>
</div>
@endsection