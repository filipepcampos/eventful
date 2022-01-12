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

                        <label for="date_from" class="form-label font-weight-bold">From</label>
                        <input id="date_from" type="datetime-local" name="date_from" class="form-control">

                        <label for="date_to" class="form-label">To</label>
                        <input id="date_to" type="datetime-local" value="{{ old('date_to') }}" name="date_to" class="form-control @if($errors->has('date_to')) is-invalid @endif">
                        @if ($errors->has('date_to'))
                        <div class="invalid-feedback d-block">
                            {{ $errors->first('date_to') }}
                        </div>
                        @endif
                    </div>
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